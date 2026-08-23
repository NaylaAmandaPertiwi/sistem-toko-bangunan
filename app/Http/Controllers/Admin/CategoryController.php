<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products');

        if ($request->filled('search')) {

            $categories->where(
                'nama_kategori',
                'like',
                '%' . $request->search . '%'
            );

        }

        $categories = $categories
            ->latest()
            ->get();

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


    /*
    |--------------------------------------------------------------------------
    | TAMBAH KATEGORI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([

            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'unique:categories,nama_kategori',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:Aktif,Nonaktif',
            ],

        ], [

            'nama_kategori.required' =>
                'Nama kategori wajib diisi.',

            'nama_kategori.unique' =>
                'Nama kategori sudah terdaftar.',

        ]);


        Category::create($data);

        return redirect()
            ->route('admin.kategori-produk.index')
            ->with(
                'success',
                'Kategori berhasil ditambahkan'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT KATEGORI
    |--------------------------------------------------------------------------
    */

    public function edit(Category $kategori_produk)
    {
        return view(
            'admin.products.edit-category',
            compact('kategori_produk')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE KATEGORI
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Category $kategori_produk
    )
    {
        $data = $request->validate([

            'nama_kategori' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'categories',
                    'nama_kategori'
                )->ignore($kategori_produk->id),
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:Aktif,Nonaktif',
            ],

        ], [

            'nama_kategori.required' =>
                'Nama kategori wajib diisi.',

            'nama_kategori.unique' =>
                'Nama kategori sudah terdaftar.',

        ]);


        $kategori_produk->update($data);

        return redirect()
            ->route('admin.kategori-produk.index')
            ->with(
                'success',
                'Kategori berhasil diperbarui'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS KATEGORI
    |--------------------------------------------------------------------------
    */

    public function destroy(Category $kategori_produk)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK RELASI PRODUK
        |--------------------------------------------------------------------------
        */

        if ($kategori_produk->products()->exists()) {

            return redirect()
                ->route('admin.kategori-produk.index')
                ->with(
                    'error',
                    'Kategori tidak dapat dihapus karena masih digunakan oleh produk.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori_produk->delete();

        return redirect()
            ->route('admin.kategori-produk.index')
            ->with(
                'success',
                'Kategori berhasil dihapus'
            );
    }
}