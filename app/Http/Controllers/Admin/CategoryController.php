<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products');

        if($request->filled('search'))
        {
            $categories->where(
                'nama_kategori',
                'like',
                '%'.$request->search.'%'
            );
        }

        $categories = $categories->latest()->get();

        return view(
            'admin.products.category',
            compact('categories')
        );
    }

    public function create()
    {
        return view(
            'admin.products.create-category'
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
            'status' => 'required'
        ]);

        Category::create($data);

        return redirect()
            ->route('admin.kategori-produk.index')
            ->with('success','Kategori berhasil ditambahkan');
    }

    public function edit(Category $kategori_produk)
    {
        return view(
            'admin.products.edit-category',
            compact('kategori_produk')
        );
    }

    public function update(
        Request $request,
        Category $kategori_produk
    )
    {
        $data = $request->validate([

            'nama_kategori' => 'required',

            'deskripsi' => 'nullable',

            'status' => 'required'

        ]);

        $kategori_produk->update($data);

        return redirect()
            ->route('admin.kategori-produk.index')
            ->with(
                'success',
                'Kategori berhasil diperbarui'
            );
    }

    public function destroy(Category $kategori_produk)
    {
        $kategori_produk->delete();

        return redirect()
            ->route('admin.kategori-produk.index')
            ->with(
                'success',
                'Kategori berhasil dihapus'
            );
    }
}