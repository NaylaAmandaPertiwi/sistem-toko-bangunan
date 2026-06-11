<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    // Daftar Produk
    public function index(Request $request)
    {
        $products = Product::with('category');

        // Filter kategori
        if($request->filled('category'))
        {
            $products->where(
                'category_id',
                $request->category
            );
        }

        // Cari produk
        if($request->filled('search'))
        {
            $products->where(
                'nama_produk',
                'like',
                '%'.$request->search.'%'
            );
        }

        $products = $products
            ->latest()
            ->get();

        $categories = Category::all();

        return view(
            'products.index',
            compact(
                'products',
                'categories'
            )
        );
    }

    // Form Tambah Produk
    public function create()
    {
        $categories = Category::all();

        return view(
            'products.create',
            compact('categories')
        );
    }

    // Simpan Produk
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required',
            'nama_produk' => 'required',
            'sku' => 'nullable',
            'barcode' => 'nullable',
            'stok' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'status' => 'required'
        ]);

        Product::create($data);

        return redirect()
            ->route('produk.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan'
            );
    }

    // Form Edit Produk
    public function edit(Product $produk)
    {
        $categories = Category::all();

        return view(
            'products.edit',
            compact(
                'produk',
                'categories'
            )
        );
    }

    // Update Produk
    public function update(
        Request $request,
        Product $produk
    )
    {
        $data = $request->validate([
            'category_id' => 'required',
            'nama_produk' => 'required',
            'sku' => 'nullable',
            'barcode' => 'nullable',
            'stok' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'status' => 'required'
        ]);

        $produk->update($data);

        return redirect()
            ->route('produk.index')
            ->with(
                'success',
                'Produk berhasil diperbarui'
            );
    }

    // Hapus Produk
    public function destroy(Product $produk)
    {
        $produk->delete();

        return redirect()
            ->route('produk.index')
            ->with(
                'success',
                'Produk berhasil dihapus'
            );
    }

    // Hapus Banyak Produk
    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->ids);

        Product::whereIn('id', $ids)->delete();

        return redirect()
            ->route('produk.index')
            ->with(
                'success',
                'Produk berhasil dihapus'
            );
    }

    // Halaman Barcode
    public function barcode()
    {
        $products = Product::all();

        return view(
            'products.barcode',
            compact('products')
        );
    }
}