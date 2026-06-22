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
        $stockOpnames = StockOpname::query();

        if($request->filled('search'))
        {
            $search = $request->search;

            $stockOpnames->where(function($query) use ($search){

                $query->where(
                    'nomor_opname',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'keterangan',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'petugas',
                    'like',
                    "%{$search}%"
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

        $request->validate([
            'tanggal_opname' => 'required',
            'petugas' => 'required',
            'status' => 'required',
            'products' => 'required|array|min:1',
        ]);

        $nomorOpname =
            'SO-' .
            now()->format('YmdHis') .
            rand(100,999);

        $opname = StockOpname::create([

            'nomor_opname'
                => $nomorOpname,

            'tanggal_opname'
                => $request->tanggal_opname,

            'keterangan'
                => $request->keterangan,

            'petugas'
                => auth()->user()->name,

            'status'
                => $request->status
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

        // hapus detail opname dulu
        StockOpnameDetail::whereIn(
            'stock_opname_id',
            $ids
        )->delete();

        // lalu hapus header opname
        StockOpname::whereIn(
            'id',
            $ids
        )->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function updateStatus(
    Request $request,
    $id
    )
    {
        $opname =
            StockOpname::findOrFail($id);

        $opname->update([

            'status' =>
                $request->status

        ]);

        return back()
            ->with(
                'success',
                'Status berhasil diperbarui'
            );
    }

    public function print($id)
    {
        $opname = StockOpname::with([
            'details.product',
            'user'
        ])->findOrFail($id);

        return view(
            'inventory.print-stock-opname',
            compact('opname')
        );
    }
}