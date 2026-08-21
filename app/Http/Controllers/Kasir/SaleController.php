<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Models\Product;
use App\Models\Discount;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\StockMovement;

class SaleController extends Controller
{
    public function index()
    {
        $products = Product::select(
                'id',
                'nama_produk',
                'harga_jual',
                'stok',
                'barcode'
            )
            ->where('status', 'Aktif')
            ->where('stok', '>', 0)
            ->orderBy('nama_produk')
            ->get();


        $today = Carbon::today();


        $discounts = Discount::select(
                'id',
                'nama_diskon',
                'minimal_belanja',
                'persentase_diskon',
                'tanggal_mulai',
                'tanggal_berakhir',
                'status'
            )
            ->where('status', 'Aktif')
            ->whereDate(
                'tanggal_mulai',
                '<=',
                $today
            )
            ->whereDate(
                'tanggal_berakhir',
                '>=',
                $today
            )
            ->orderByDesc('minimal_belanja')
            ->get();


        return view(
            'kasir.penjualan.index',
            compact(
                'products',
                'discounts'
            )
        );
    }

    public function searchProduct(Request $request)
    {
        $products = Product::where(function ($query) use ($request) {

                $query->where(
                    'nama_produk',
                    'like',
                    '%' . $request->keyword . '%'
                )
                ->orWhere(
                    'barcode',
                    'like',
                    '%' . $request->keyword . '%'
                );

            })
            ->where('status', 'Aktif')
            ->where('stok', '>', 0)
            ->orderBy('nama_produk')
            ->get();

        return response()->json($products);
    }
    public function store(Request $request)
    {
        $request->validate([
            'subtotal'   => 'required|numeric',
            'diskon'     => 'required|numeric',
            'total'      => 'required|numeric',
            'bayar'      => 'required|numeric',
            'kembalian'  => 'required|numeric',
            'items'      => 'required|array|min:1'
        ]);

        DB::beginTransaction();

        try {

            $sale = Sale::create([

                'kode_penjualan' => 'PJ-' . now()->format('YmdHis'),

                'tanggal'        => now(),

                'user_id'        => Auth::id(),

                'subtotal'       => $request->subtotal,

                'diskon'         => $request->diskon,

                'total_bayar'    => $request->total,

                'bayar'          => $request->bayar,

                'kembalian'      => $request->kembalian,

            ]);

            foreach ($request->items as $item) {

                $product = Product::where('id', $item['id'])
                    ->where('status', 'Aktif')
                    ->where('stok', '>', 0)
                    ->first();

                if (!$product) {

                    throw new \Exception(
                        'Produk tidak tersedia atau sudah Nonaktif.'
                    );
                }

                if ($product->stok < $item['qty']) {

                    throw new \Exception(
                        "Stok {$product->nama_produk} tidak mencukupi."
                    );
                }

                SaleDetail::create([

                    'sale_id'    => $sale->id,

                    'product_id' => $product->id,

                    'qty'        => $item['qty'],

                    'harga'      => $item['harga'],

                    'subtotal'   => $item['qty'] * $item['harga']

                ]);

                $stokAwal = $product->stok;

                $stokAkhir = $stokAwal - $item['qty'];

                $product->update([

                    'stok' => $stokAkhir

                ]);

                StockMovement::create([

                    'product_id' => $product->id,

                    'tanggal'    => now(),

                    'jenis'      => 'Keluar',

                    'qty'        => $item['qty'],

                    'stok_awal'  => $stokAwal,

                    'stok_akhir' => $stokAkhir,

                    'keterangan' => 'Penjualan ' . $sale->kode_penjualan

                ]);
            }

            DB::commit();

            return response()->json([

                'success' => true,

                'sale_id' => $sale->id,

                'kode_penjualan' => $sale->kode_penjualan,

                'print_url' => route(
                    'print.sale',
                    $sale->id
                )

            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ],500);

        }
    }

    public function searchBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)
            ->where('status', 'Aktif')
            ->whereHas('category', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk dengan barcode tersebut tidak ditemukan.'
            ], 404);
        }

        if ($product->stok <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk habis.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'nama_produk' => $product->nama_produk,
                'barcode' => $product->barcode,
                'harga_jual' => $product->harga_jual,
                'stok' => $product->stok,
            ]
        ]);
    }

    public function print(Sale $sale)
    {
        $sale->load([

            'user',

            'saleDetails.product'

        ]);

        return view(

            'shared.print',

            compact('sale')

        );
    }

}