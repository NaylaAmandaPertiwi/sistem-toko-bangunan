<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;

class StockOpnameController extends Controller
{
    // Halaman daftar stok opname
    public function index()
    {
        $stockOpnames = StockOpnameDetail::with([
            'product',
            'stockOpname'
        ])->latest()->get();

        return view(
            'inventory.stok-opname',
            compact('stockOpnames')
        );
    }

    // Halaman tambah stok opname
    public function create()
    {
        $products = Product::all();

        return view(
            'inventory.create-stock-opname',
            compact('products')
        );
    }

    // Simpan stok opname
    public function store(Request $request)
    {
        $opname = StockOpname::create([

            'nomor_opname'
                => 'SO-'.date('YmdHis'),

            'tanggal_opname'
                => $request->tanggal_opname,

            'keterangan'
                => $request->keterangan,

            'status'
                => 'Selesai'
        ]);

        foreach($request->products as $item)
        {
            $selisih =
                $item['stok_fisik']
                -
                $item['stok_sistem'];

            StockOpnameDetail::create([

                'stock_opname_id'
                    => $opname->id,

                'product_id'
                    => $item['product_id'],

                'stok_sistem'
                    => $item['stok_sistem'],

                'stok_fisik'
                    => $item['stok_fisik'],

                'selisih'
                    => $selisih
            ]);

            Product::where(
                'id',
                $item['product_id']
            )->update([

                'stok'
                    => $item['stok_fisik']
            ]);
        }

        return redirect()
            ->route('stok-opname.index');
    }

    // Detail stok opname
    public function show($id)
    {
        $opname = StockOpname::with(
            'details.product'
        )->findOrFail($id);

        return view(
            'inventory.detail-stock-opname',
            compact('opname')
        );
    }
}