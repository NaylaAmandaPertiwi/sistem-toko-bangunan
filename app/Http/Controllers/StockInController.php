<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockIn;
use App\Models\Product;
use App\Models\Supplier;

class StockInController extends Controller
{
    public function index(Request $request)
    {
        $query = StockIn::with([
            'supplier',
            'product'
        ]);

        if($request->start_date && $request->end_date)
        {
            $query->whereBetween(
                'tanggal_masuk',
                [
                    $request->start_date,
                    $request->end_date
                ]
            );
        }

        if($request->search)
        {
            $query->where(
                'nomor_transaksi',
                'like',
                '%' . $request->search . '%'
            );
        }

        $stockIns = $query
            ->latest()
            ->get();

        return view(
            'inventory.stok-masuk',
            compact('stockIns')
        );
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();

        return view(
            'inventory.create-stock-in',
            compact(
                'products',
                'suppliers'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'nomor_transaksi' => 'required',

            'tanggal_masuk' => 'required',

            'supplier_id' => 'required',

            'product_id' => 'required',

            'jumlah_masuk' => 'required|numeric',

            'harga_beli' => 'required|numeric'

        ]);

        StockIn::create([

            'nomor_transaksi' => $request->nomor_transaksi,

            'tanggal_masuk' => $request->tanggal_masuk,

            'supplier_id' => $request->supplier_id,

            'product_id' => $request->product_id,

            'jumlah_masuk' => $request->jumlah_masuk,

            'harga_beli' => $request->harga_beli,

            'keterangan' => $request->keterangan

        ]);

        return redirect()
            ->route('stok-masuk.index')
            ->with(
                'success',
                'Data stok masuk berhasil disimpan'
            );
    }

    public function edit($id)
    {
        $stockIn = StockIn::findOrFail($id);

        $products = Product::all();
        $suppliers = Supplier::all();

        return view(
            'inventory.create-stock-in',
            compact(
                'stockIn',
                'products',
                'suppliers'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $stockIn = StockIn::findOrFail($id);

        $stockIn->update([
            'tanggal_masuk' => $request->tanggal_masuk,
            'supplier_id' => $request->supplier_id,
            'product_id' => $request->product_id,
            'jumlah_masuk' => $request->jumlah_masuk,
            'harga_beli' => $request->harga_beli,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('stok-masuk.index')
            ->with(
                'success',
                'Data berhasil diperbarui'
            );
    }

    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);

        StockIn::whereIn('id', $ids)->delete();

        return redirect()
            ->route('stok-masuk.index')
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }
}
