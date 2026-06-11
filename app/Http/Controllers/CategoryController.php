<?php

namespace App\Http\Controllers;

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
            'products.category',
            compact('categories')
        );
    }

    public function create()
    {
        return view('products.create-category');
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
            ->route('kategori-produk.index')
            ->with('success','Kategori berhasil ditambahkan');
    }

    public function edit(Category $kategori_produk)
    {
        return view(
            'products.edit-category',
            compact('kategori_produk')
        );
    }

    public function update(
        Request $request,
        Category $kategori_produk
    )
    {
        $kategori_produk->update(
            $request->all()
        );

        return redirect()
            ->route('kategori-produk.index');
    }

    public function destroy(Category $kategori_produk)
    {
        $kategori_produk->delete();

        return redirect()
            ->route('kategori-produk.index');
    }
}