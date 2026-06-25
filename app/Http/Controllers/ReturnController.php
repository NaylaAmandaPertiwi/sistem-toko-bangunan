<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ReturnDetail;
use App\Models\ReturnSale;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Retur
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $returns = ReturnSale::with('sale')
            ->latest()
            ->get();

        return view(
            'transaksi.retur',
            compact('returns')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Form Tambah Retur
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $sales = Sale::latest()->get();

        return view(
            'transaksi.create-retur',
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
        DB::beginTransaction();

        try {

            $returnSale = ReturnSale::create([

                'kode_retur' =>
                    'RT-' . time(),

                'sale_id' =>
                    $request->sale_id,

                'tanggal' =>
                    now(),

                'total_retur' =>
                    0,

                'keterangan' =>
                    $request->keterangan

            ]);

            $totalRetur = 0;

            if ($request->filled('items')) {

                $items = json_decode(
                    $request->items,
                    true
                );

                foreach ($items as $item) {

                    ReturnDetail::create([

                        'return_sale_id' =>
                            $returnSale->id,

                        'product_id' =>
                            $item['product_id'],

                        'qty' =>
                            $item['qty'],

                        'harga' =>
                            $item['harga'],

                        'subtotal' =>
                            $item['subtotal']

                    ]);

                    Product::where(
                        'id',
                        $item['product_id']
                    )->increment(
                        'stok',
                        $item['qty']
                    );

                    $totalRetur +=
                        $item['subtotal'];
                }
            }

            $returnSale->update([

                'total_retur' =>
                    $totalRetur

            ]);

            DB::commit();

            return redirect()
                ->route('retur.index')
                ->with(
                    'success',
                    'Retur berhasil disimpan.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
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

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}