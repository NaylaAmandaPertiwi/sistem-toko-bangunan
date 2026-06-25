<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $products =
            Product::where(
                'status',
                'Aktif'
            )->get();

        return view(
            'transaksi.penjualan',
            compact('products')
        );
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try{

            $sale = Sale::create([

                'kode_penjualan' =>
                    'PJ-' . time(),

                'tanggal' =>
                    now(),

                'subtotal' =>
                    $request->subtotal,

                'diskon' =>
                    $request->diskon,

                'total_bayar' =>
                    $request->total_bayar,

                'bayar' =>
                    $request->bayar,

                'kembalian' =>
                    $request->kembalian

            ]);

            $items = json_decode(
                $request->items,
                true
            );

            foreach($items as $item)
            {
                SaleDetail::create([

                    'sale_id' =>
                        $sale->id,

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
                )->decrement(
                    'stok',
                    $item['qty']
                );
            }

            DB::commit();

            return redirect()
                ->route('penjualan.index')
                ->with(
                    'success',
                    'Transaksi berhasil disimpan'
                );

        }catch(\Exception $e){

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}