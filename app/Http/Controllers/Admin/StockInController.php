<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockMovement;
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

        if($request->filled('search'))
        {
            $search = $request->search;

            $query->where(function($q) use ($search){

                $q->where(
                    'nomor_transaksi',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'tanggal_masuk',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('supplier', function($supplier) use ($search){

                    $supplier->where(
                        'nama_supplier',
                        'like',
                        "%{$search}%"
                    );

                })

                ->orWhereHas('product', function($product) use ($search){

                    $product->where(
                        'nama_produk',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'sku',
                        'like',
                        "%{$search}%"
                    );

                });

            });
        }

        $stockIns = $query->latest()->get();

        return view(
            'admin.inventory.stok-masuk',
            compact('stockIns')
        );
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();

        return view(
            'admin.inventory.create-stock-in',
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

        $product =
            Product::findOrFail(
                $request->product_id
            );

        $stokAwal =
            $product->stok;

        $stokAkhir =
            $stokAwal +
            $request->jumlah_masuk;

        $product->update([

            'stok' => $stokAkhir

        ]);

        StockMovement::create([

            'product_id'
                => $product->id,

            'tanggal'
                => now(),

            'jenis'
                => 'Masuk',

            'qty'
                => $request->jumlah_masuk,

            'stok_awal'
                => $stokAwal,

            'stok_akhir'
                => $stokAkhir,

            'keterangan'
                => 'Stok Masuk Supplier'

        ]);

        return redirect()
            ->route('admin.stok-masuk.index')
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
            'admin.inventory.create-stock-in',
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
            ->route('admin.stok-masuk.index')
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
            ->route('admin.stok-masuk.index')
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }
}
