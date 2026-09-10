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

    private function generateCategoryCode(string $categoryName): string
    {
        // Ubah menjadi huruf kapital
        $categoryName = strtoupper($categoryName);

        // Hanya sisakan huruf A-Z
        $categoryName = preg_replace('/[^A-Z]/', '', $categoryName);

        // Ambil 3 huruf pertama
        return substr($categoryName, 0, 3);
    }

    private function generateSku(Category $category): string
    {
        // Membuat kode kategori
        $categoryCode = $this->generateCategoryCode(
            $category->nama_kategori
        );

        // Ambil semua SKU dengan prefix kategori yang sama
        $skus = Product::whereNotNull('sku')
            ->where('sku', 'like', $categoryCode . '-%')
            ->pluck('sku');

        // Cari nomor terbesar dari SKU yang sudah ada
        $maxNumber = 0;

        foreach ($skus as $sku) {

            // Ambil bagian angka setelah tanda "-"
            $number = (int) substr(
                $sku,
                strlen($categoryCode) + 1
            );

            if ($number > $maxNumber) {
                $maxNumber = $number;
            }
        }

        // Nomor SKU berikutnya
        $nextNumber = $maxNumber + 1;

        // Format menjadi 5 digit
        return $categoryCode . '-' . str_pad(
            $nextNumber,
            5,
            '0',
            STR_PAD_LEFT
        );
    }

    public function previewSku(Request $request)
    {
        $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | AMBIL KATEGORI
        |--------------------------------------------------------------------------
        */

        $category = Category::findOrFail(
            $request->category_id
        );


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($category->status !== 'Aktif') {

            return response()->json([
                'success' => false,
                'message' => 'Kategori yang dipilih sedang nonaktif.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE SKU
        |--------------------------------------------------------------------------
        */

        $sku = $this->generateSku(
            $category
        );


        /*
        |--------------------------------------------------------------------------
        | KIRIM SKU KE HALAMAN
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'sku' => $sku
        ]);
    }

    // Simpan Produk
    
    public function store(Request $request)
    {
        $data = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | KATEGORI
            |--------------------------------------------------------------------------
            */

            'category_id' => [
                'required',
                'exists:categories,id',

                function ($attribute, $value, $fail) {

                    $category = Category::find($value);

                    if (!$category || $category->status !== 'Aktif') {

                        $fail(
                            'Kategori yang dipilih sedang nonaktif.'
                        );
                    }
                },
            ],


            /*
            |--------------------------------------------------------------------------
            | NAMA PRODUK
            |--------------------------------------------------------------------------
            */

            'nama_produk' => [
                'required',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | STOK AWAL
            |--------------------------------------------------------------------------
            */

            'stok' => [
                'required',
                'integer',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | STOK MINIMUM
            |--------------------------------------------------------------------------
            */

            'stok_minimum' => [
                'required',
                'integer',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | SATUAN
            |--------------------------------------------------------------------------
            */

            'satuan' => [
                'required',
                'string',
                'max:50',
            ],


            /*
            |--------------------------------------------------------------------------
            | HARGA BELI
            |--------------------------------------------------------------------------
            */

            'harga_beli' => [
                'required',
                'numeric',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | HARGA JUAL
            |--------------------------------------------------------------------------
            */

            'harga_jual' => [
                'required',
                'numeric',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                'in:Aktif,Nonaktif',
            ],

        ], [

            /*
            |--------------------------------------------------------------------------
            | PESAN VALIDASI
            |--------------------------------------------------------------------------
            */

            'category_id.required' =>
                'Kategori wajib dipilih.',

            'category_id.exists' =>
                'Kategori yang dipilih tidak valid.',


            'nama_produk.required' =>
                'Nama produk wajib diisi.',

            'nama_produk.string' =>
                'Nama produk harus berupa teks.',


            'stok.required' =>
                'Stok awal wajib diisi.',

            'stok.integer' =>
                'Stok awal harus berupa angka bulat.',

            'stok.min' =>
                'Stok awal tidak boleh kurang dari 0.',


            'stok_minimum.required' =>
                'Stok minimum wajib diisi.',

            'stok_minimum.integer' =>
                'Stok minimum harus berupa angka bulat.',

            'stok_minimum.min' =>
                'Stok minimum tidak boleh kurang dari 0.',


            'satuan.required' =>
                'Satuan wajib diisi.',


            'harga_beli.required' =>
                'Harga beli wajib diisi.',

            'harga_beli.numeric' =>
                'Harga beli harus berupa angka.',

            'harga_beli.min' =>
                'Harga beli tidak boleh kurang dari 0.',


            'harga_jual.required' =>
                'Harga jual wajib diisi.',

            'harga_jual.numeric' =>
                'Harga jual harus berupa angka.',

            'harga_jual.min' =>
                'Harga jual tidak boleh kurang dari 0.',


            'status.required' =>
                'Status produk wajib dipilih.',

            'status.in' =>
                'Status produk tidak valid.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | AMBIL KATEGORI
        |--------------------------------------------------------------------------
        |
        | Kategori digunakan untuk menentukan kode awal SKU.
        |
        | Contoh:
        | Cat   → CAT
        | Semen → SEM
        | Paku  → PAK
        |
        */

        $category = Category::findOrFail(
            $data['category_id']
        );


        /*
        |--------------------------------------------------------------------------
        | GENERATE SKU OTOMATIS
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | Produk pertama kategori Cat   → CAT-00001
        | Produk kedua kategori Cat     → CAT-00002
        | Produk pertama kategori Semen → SEM-00001
        |
        */

        $data['sku'] = $this->generateSku(
            $category
        );

        // Barcode otomatis menggunakan nilai SKU
        $data['barcode'] = $data['sku'];


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PRODUK
        |--------------------------------------------------------------------------
        */

        Product::create($data);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

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

            /*
            |--------------------------------------------------------------------------
            | KATEGORI
            |--------------------------------------------------------------------------
            */

            'category_id' => [
                'required',
                'exists:categories,id',

                function ($attribute, $value, $fail) use ($produk) {

                    /*
                    | Jika kategori tidak berubah,
                    | tetap izinkan menggunakan kategori tersebut.
                    */

                    if ((int) $value === (int) $produk->category_id) {

                        return;

                    }


                    /*
                    | Jika memilih kategori baru,
                    | kategori harus Aktif.
                    */

                    $category = Category::find($value);

                    if (!$category || $category->status !== 'Aktif') {

                        $fail(
                            'Kategori yang dipilih sedang nonaktif.'
                        );

                    }
                },
            ],


            /*
            |--------------------------------------------------------------------------
            | NAMA PRODUK
            |--------------------------------------------------------------------------
            */

            'nama_produk' => [
                'required',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | STOK
            |--------------------------------------------------------------------------
            */

            'stok' => [
                'required',
                'integer',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | STOK MINIMUM
            |--------------------------------------------------------------------------
            */

            'stok_minimum' => [
                'required',
                'integer',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | SATUAN
            |--------------------------------------------------------------------------
            */

            'satuan' => [
                'required',
                'string',
                'max:50',
            ],


            /*
            |--------------------------------------------------------------------------
            | HARGA BELI
            |--------------------------------------------------------------------------
            */

            'harga_beli' => [
                'required',
                'numeric',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | HARGA JUAL
            |--------------------------------------------------------------------------
            */

            'harga_jual' => [
                'required',
                'numeric',
                'min:0',
            ],


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                'in:Aktif,Nonaktif',
            ],

        ], [

            /*
            |--------------------------------------------------------------------------
            | PESAN VALIDASI
            |--------------------------------------------------------------------------
            */

            'category_id.required' =>
                'Kategori wajib dipilih.',

            'category_id.exists' =>
                'Kategori yang dipilih tidak valid.',


            'nama_produk.required' =>
                'Nama produk wajib diisi.',

            'nama_produk.string' =>
                'Nama produk harus berupa teks.',


            'stok.required' =>
                'Stok wajib diisi.',

            'stok.integer' =>
                'Stok harus berupa angka bulat.',

            'stok.min' =>
                'Stok tidak boleh kurang dari 0.',


            'stok_minimum.required' =>
                'Stok minimum wajib diisi.',

            'stok_minimum.integer' =>
                'Stok minimum harus berupa angka bulat.',

            'stok_minimum.min' =>
                'Stok minimum tidak boleh kurang dari 0.',


            'satuan.required' =>
                'Satuan wajib diisi.',


            'harga_beli.required' =>
                'Harga beli wajib diisi.',

            'harga_beli.numeric' =>
                'Harga beli harus berupa angka.',

            'harga_beli.min' =>
                'Harga beli tidak boleh kurang dari 0.',


            'harga_jual.required' =>
                'Harga jual wajib diisi.',

            'harga_jual.numeric' =>
                'Harga jual harus berupa angka.',

            'harga_jual.min' =>
                'Harga jual tidak boleh kurang dari 0.',


            'status.required' =>
                'Status produk wajib dipilih.',

            'status.in' =>
                'Status produk tidak valid.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | PERTAHANKAN SKU DAN BARCODE
        |--------------------------------------------------------------------------
        |
        | SKU dan barcode tidak diubah melalui halaman Edit.
        | Keduanya tetap mengikuti data produk.
        |
        */

        $data['sku'] = $produk->sku;
        $data['barcode'] = $produk->sku;


        /*
        |--------------------------------------------------------------------------
        | UPDATE PRODUK
        |--------------------------------------------------------------------------
        */

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
        $products = Product::with('category')
            ->where('status', 'Aktif')
            ->whereHas('category', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->orderBy('nama_produk')
            ->get();

        $categories = Category::where('status', 'Aktif')
            ->orderBy('nama_kategori')
            ->get();

        return view(
            'admin.products.barcode',
            compact(
                'products',
                'categories'
            )
        );
    }

    public function printBarcode(Product $product)
    {
        if (
            $product->status !== 'Aktif' ||
            !$product->category ||
            $product->category->status !== 'Aktif'
        ) {
            abort(404);
        }

        if (empty($product->barcode)) {

            return redirect()
                ->route('admin.barcode')
                ->with(
                    'error',
                    'Produk belum memiliki barcode.'
                );
        }

        return view(
            'admin.products.print-barcode',
            compact('product')
        );
    }

    public function printAllBarcode(Request $request)
    {
        $query = Product::with('category')
            ->where('status', 'Aktif')
            ->whereHas('category', function ($query) {
                $query->where('status', 'Aktif');
            })
            ->whereNotNull('barcode')
            ->where('barcode', '!=', '');

        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category_id')) {

            $query->where(
                'category_id',
                $request->category_id
            );

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {

                $q->where(
                    'nama_produk',
                    'like',
                    '%' . $keyword . '%'
                )
                ->orWhere(
                    'barcode',
                    'like',
                    '%' . $keyword . '%'
                )
                ->orWhere(
                    'sku',
                    'like',
                    '%' . $keyword . '%'
                );

            });

        }

        $products = $query
            ->orderBy('nama_produk')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA PRODUK YANG DAPAT DICETAK
        |--------------------------------------------------------------------------
        */

        if ($products->isEmpty()) {

            return redirect()
                ->route('admin.barcode')
                ->with(
                    'error',
                    'Tidak ada produk yang dapat dicetak.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN HALAMAN CETAK
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.products.barcode-print-all',
            compact('products')
        );
    }

}