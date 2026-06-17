<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;

class StockOpnameController extends Controller
{
    // Halaman daftar stok opname
    public function index(Request $request)
    {
        $stockOpnames = StockOpnameDetail::with([
            'product',
            'stockOpname'
        ]);

        if($request->filled('search'))
        {
            $search = $request->search;

            $stockOpnames->where(function($query) use ($search){

                $query->whereHas(
                    'stockOpname',
                    function($q) use ($search){

                        $q->where(
                            'nomor_opname',
                            'like',
                            '%'.$search.'%'
                        );

                    }
                )

                ->orWhereHas(
                    'product',
                    function($q) use ($search){

                        $q->where(
                            'nama_produk',
                            'like',
                            '%'.$search.'%'
                        )

                        ->orWhere(
                            'sku',
                            'like',
                            '%'.$search.'%'
                        );

                    }
                );

            });
        }

        $stockOpnames = $stockOpnames
            ->latest()
            ->get();

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
            'inventory.show-stock-opname',
            compact('opname')
        );
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(
            ',',
            $request->ids
        );

        StockOpnameDetail::whereIn(
            'id',
            $ids
        )->delete();

        return response()->json([
            'success' => true
        ]);
    }
}