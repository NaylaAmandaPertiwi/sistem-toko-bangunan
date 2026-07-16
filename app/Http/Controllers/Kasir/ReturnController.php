<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\ReturnSale;
use App\Models\ReturnDetail;
use App\Models\StockMovement;

class ReturnController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Retur
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $sales = Sale::with('user')

            ->latest()

            ->paginate(10);

        return view(

            'kasir.retur.index',

            compact('sales')

        );
    }

    public function detail(Sale $sale)
    {
        $sale->load([

            'user',

            'saleDetails.product'

        ]);

        return response()->json([

            'success' => true,

            'sale' => $sale

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Form Tambah Retur
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $sales = Sale::with([

            'saleDetails.product'

        ])

        ->latest()

        ->paginate(20);

        return view(

            'kasir.retur.create',

            compact('sales')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Retur
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'sale_id' => 'required|exists:sales,id',

            'items' => 'required|array|min:1',

            'keterangan' => 'nullable|string|max:255'

        ]);

        DB::beginTransaction();

        try {

            $returnSale = ReturnSale::create([

                'kode_retur' =>

                    'RT-' . now()->format('YmdHis'),

                'sale_id' =>

                    $request->sale_id,

                'user_id' =>

                    Auth::id(),

                'tanggal' =>

                    now(),

                'total_retur' =>

                    0,

                'keterangan' =>

                    $request->keterangan

            ]);

            $totalRetur = 0;

            $items = $request->items;

            foreach ($items as $item) {

                $saleDetail = SaleDetail::findOrFail(

                    $item['sale_detail_id']

                );

                if ($item['qty'] > $saleDetail->qty) {

                    throw new \Exception(

                        "Qty retur produk {$saleDetail->product->nama_produk} melebihi jumlah pembelian."

                    );

                }

                $subtotal =

                    $item['qty']

                    *

                    $saleDetail->harga;

                $totalRetur += $subtotal;

                ReturnDetail::create([

                    'return_sale_id' =>

                        $returnSale->id,

                    'sale_detail_id' =>

                        $saleDetail->id,

                    'product_id' =>

                        $saleDetail->product_id,

                    'qty' =>

                        $item['qty'],

                    'harga' =>

                        $saleDetail->harga,

                    'subtotal' =>

                        $subtotal

                ]);

                /*
                |--------------------------------------------------------------------------
                | Update Stok Produk
                |--------------------------------------------------------------------------
                */

                $product = Product::findOrFail(
                    $saleDetail->product_id
                );

                $stokAwal = $product->stok;

                $product->increment(
                    'stok',
                    $item['qty']
                );

                $product->refresh();

                $stokAkhir = $product->stok;

                /*
                |--------------------------------------------------------------------------
                | Catat Riwayat Pergerakan Stok
                |--------------------------------------------------------------------------
                */

                StockMovement::create([

                    'product_id' => $product->id,

                    'tanggal' => now(),

                    'jenis' => 'retur',

                    'qty' => $item['qty'],

                    'stok_awal' => $stokAwal,

                    'stok_akhir' => $stokAkhir,

                    'keterangan' =>

                        'Retur Penjualan ' .

                        $returnSale->kode_retur

                ]);

                Product::where(

                    'id',

                    $saleDetail->product_id

                )->increment(

                    'stok',

                    $item['qty']

                );

            }

            $returnSale->update([

                'total_retur' => $totalRetur

            ]);

            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Retur berhasil disimpan.',

                'return_sale_id' => $returnSale->id

            ]);

        }

        catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 422);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Detail Retur
    |--------------------------------------------------------------------------
    */

    public function show(ReturnSale $retur)
    {
        $retur->load(
            'sale',
            'details.product'
        );

        return view(
            'transaksi.detail-retur',
            compact('retur')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Retur
    |--------------------------------------------------------------------------
    */

    public function destroy(ReturnSale $retur)
    {
        DB::beginTransaction();

        try {

            foreach ($retur->details as $detail) {

                Product::where(
                    'id',
                    $detail->product_id
                )->decrement(
                    'stok',
                    $detail->qty
                );
            }

            $retur->delete();

            DB::commit();

            return redirect()
                ->route('retur.index')
                ->with(
                    'success',
                    'Data retur berhasil dihapus.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 422);

        }
    }
}