<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Exports\StockReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class StockReportController extends Controller
{
    /**
     * Laporan Stok
     */
    public function stok(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY PRODUK
        |--------------------------------------------------------------------------
        */

        $query = Product::with('category');


        /*
        |--------------------------------------------------------------------------
        | FILTER PENCARIAN PRODUK
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->get('search', '')
        );

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_produk',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'sku',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'barcode',
                    'like',
                    '%' . $search . '%'
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        $category = $request->get(
            'category',
            ''
        );

        if ($category !== '') {

            $query->where(
                'category_id',
                $category
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS STOK
        |--------------------------------------------------------------------------
        */

        $statusStok = $request->get(
            'status_stok',
            ''
        );

        if ($statusStok === 'habis') {

            $query->where(
                'stok',
                '<=',
                0
            );

        }

        elseif ($statusStok === 'menipis') {

            $query->whereColumn(
                'stok',
                '<=',
                'stok_minimum'
            );

            $query->where(
                'stok',
                '>',
                0
            );

        }

        elseif ($statusStok === 'aman') {

            $query->whereColumn(
                'stok',
                '>',
                'stok_minimum'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA PRODUK
        |--------------------------------------------------------------------------
        */

        $products = $query
            ->orderBy('nama_produk')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DATA KATEGORI
        |--------------------------------------------------------------------------
        */

        $categories = Category::orderBy(
            'nama_kategori'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalProduk = $products->count();

        $totalStok = $products->sum('stok');

        $stokMenipis = $products
            ->filter(function ($product) {

                return $product->stok > 0
                    && $product->stok <= $product->stok_minimum;

            })
            ->count();

        $stokHabis = $products
            ->filter(function ($product) {

                return $product->stok <= 0;

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.stok',
            compact(
                'products',
                'categories',
                'search',
                'category',
                'statusStok',
                'totalProduk',
                'totalStok',
                'stokMenipis',
                'stokHabis'
            )
        );
    }

    public function filter(Request $request)
    {
        $query = Product::with('category');

        $search = trim($request->get('search', ''));

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where('nama_produk', 'like', '%' . $search . '%')
                ->orWhere('sku', 'like', '%' . $search . '%')
                ->orWhere('barcode', 'like', '%' . $search . '%');

            });
        }

        $category = $request->get('category', '');

        if ($category !== '') {
            $query->where('category_id', $category);
        }

        $statusStok = $request->get('status_stok', '');

        if ($statusStok === 'habis') {

            $query->where('stok', '<=', 0);

        } elseif ($statusStok === 'menipis') {

            $query->whereColumn('stok', '<=', 'stok_minimum')
                ->where('stok', '>', 0);

        } elseif ($statusStok === 'aman') {

            $query->whereColumn('stok', '>', 'stok_minimum');
        }

        $products = $query
            ->orderBy('nama_produk')
            ->get();

        return response()->json([
            'products' => $products->map(function ($product) {

                if ($product->stok <= 0) {
                    $status = 'Habis';
                } elseif ($product->stok <= $product->stok_minimum) {
                    $status = 'Menipis';
                } else {
                    $status = 'Aman';
                }

                return [
                    'nama_produk' => $product->nama_produk,
                    'sku' => $product->sku ?? '-',
                    'kategori' => $product->category->nama_kategori ?? '-',
                    'stok' => $product->stok,
                    'satuan' => $product->satuan,
                    'stok_minimum' => $product->stok_minimum,
                    'status' => $status,
                ];
            }),
        ]);
    }


    /**
     * Cetak Laporan Stok PDF
     */
    public function stokPdf(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY PRODUK
        |--------------------------------------------------------------------------
        */

        $query = Product::with('category');


        /*
        |--------------------------------------------------------------------------
        | FILTER PENCARIAN PRODUK
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->get('search', '')
        );

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_produk',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'sku',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'barcode',
                    'like',
                    '%' . $search . '%'
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        $category = $request->get(
            'category',
            ''
        );

        if ($category !== '') {

            $query->where(
                'category_id',
                $category
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS STOK
        |--------------------------------------------------------------------------
        */

        $statusStok = $request->get(
            'status_stok',
            ''
        );

        if ($statusStok === 'habis') {

            $query->where(
                'stok',
                '<=',
                0
            );

        }

        elseif ($statusStok === 'menipis') {

            $query->whereColumn(
                'stok',
                '<=',
                'stok_minimum'
            );

            $query->where(
                'stok',
                '>',
                0
            );

        }

        elseif ($statusStok === 'aman') {

            $query->whereColumn(
                'stok',
                '>',
                'stok_minimum'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA PRODUK
        |--------------------------------------------------------------------------
        */

        $products = $query
            ->orderBy('nama_produk')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalProduk = $products->count();

        $totalStok = $products->sum('stok');

        $stokMenipis = $products
            ->filter(function ($product) {

                return $product->stok > 0
                    && $product->stok <= $product->stok_minimum;

            })
            ->count();

        $stokHabis = $products
            ->filter(function ($product) {

                return $product->stok <= 0;

            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'admin.laporan.pdf.stok',
            compact(
                'products',
                'search',
                'category',
                'statusStok',
                'totalProduk',
                'totalStok',
                'stokMenipis',
                'stokHabis'
            )
        );

        return $pdf->download(
            'laporan-stok.pdf'
        );
    }


    /**
     * Export Laporan Stok Excel
     */
    public function stokExcel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY PRODUK
        |--------------------------------------------------------------------------
        */

        $query = Product::with('category');


        /*
        |--------------------------------------------------------------------------
        | FILTER PENCARIAN
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->get('search', '')
        );

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_produk',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'sku',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'barcode',
                    'like',
                    '%' . $search . '%'
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        $category = $request->get(
            'category',
            ''
        );

        if ($category !== '') {

            $query->where(
                'category_id',
                $category
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS STOK
        |--------------------------------------------------------------------------
        */

        $statusStok = $request->get(
            'status_stok',
            ''
        );

        if ($statusStok === 'habis') {

            $query->where(
                'stok',
                '<=',
                0
            );

        }

        elseif ($statusStok === 'menipis') {

            $query->whereColumn(
                'stok',
                '<=',
                'stok_minimum'
            );

            $query->where(
                'stok',
                '>',
                0
            );

        }

        elseif ($statusStok === 'aman') {

            $query->whereColumn(
                'stok',
                '>',
                'stok_minimum'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA PRODUK
        |--------------------------------------------------------------------------
        */

        $products = $query
            ->orderBy('nama_produk')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | NAMA KATEGORI
        |--------------------------------------------------------------------------
        */

        $categoryLabel = 'Semua Kategori';

        if ($category !== '') {

            $categoryModel = Category::find($category);

            $categoryLabel = $categoryModel
                ? $categoryModel->nama_kategori
                : '-';
        }


        /*
        |--------------------------------------------------------------------------
        | EXPORT EXCEL
        |--------------------------------------------------------------------------
        */

        return Excel::download(

            new StockReportExport(
                $products,
                $search,
                $category,
                $statusStok,
                $categoryLabel
            ),

            'laporan-stok.xlsx'
        );
    }
}