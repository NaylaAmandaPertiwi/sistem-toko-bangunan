<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    // Daftar Produk
    public function index(Request $request)
    {
        $products = Product::with('category')
        ->whereHas('category', function ($query) {
            $query->where('status', 'Aktif');
        });

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

        $categories = Category::where('status', 'Aktif')
            ->orderBy('nama_kategori')
            ->get();

        return view(
            'admin.products.index',
            compact(
                'products',
                'categories'
            )
        );
    }

    // Form Tambah Produk
    public function create()
    {
        $categories = Category::where('status', 'Aktif')
            ->orderBy('nama_kategori')
            ->get();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }

    // Simpan Produk
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
                function ($attribute, $value, $fail) {

                    $category = Category::find($value);

                    if (!$category || $category->status !== 'Aktif') {
                        $fail('Kategori yang dipilih sedang nonaktif.');
                    }
                },
            ],
            'nama_produk' => 'required',
            'sku' => 'nullable',
            'barcode' => 'nullable',
            'stok' => 'required',
            'stok_minimum' => 'required|numeric',
            'satuan' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'status' => 'required'
        ]);

        Product::create($data);

        return redirect()
            ->route('admin.produk.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan'
            );
    }

    // Form Edit Produk
    public function edit(Product $produk)
    {
        $categories = Category::where('status', 'Aktif')
            ->orWhere('id', $produk->category_id)
            ->orderBy('nama_kategori')
            ->get();

        return view(
            'admin.products.edit',
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
            'category_id' => [
                'required',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($produk) {

                    // Jika kategori tidak berubah,
                    // tetap izinkan menggunakan kategori lama
                    if ((int) $value === (int) $produk->category_id) {
                        return;
                    }

                    // Jika memilih kategori baru,
                    // kategori tersebut harus Aktif
                    $category = Category::find($value);

                    if (!$category || $category->status !== 'Aktif') {
                        $fail('Kategori yang dipilih sedang nonaktif.');
                    }
                },
            ],
            'nama_produk' => 'required',
            'sku' => 'nullable',
            'barcode' => 'nullable',
            'stok' => 'required',
            'stok_minimum' => 'required|numeric',
            'satuan' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'status' => 'required'
        ]);

        $produk->update($data);

        return redirect()
            ->route('admin.produk.index')
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
            ->route('admin.produk.index')
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
            ->route('admin.produk.index')
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
            'admin.products.barcode',
            compact('products')
        );
    }
}