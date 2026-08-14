<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SaleDetail;
use App\Models\Category;
use App\Exports\BestSellingReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class BestSellingReportController extends Controller
{
    /**
     * Laporan Barang Terlaris
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $request->get('tanggal_mulai', '');

        $tanggalAkhir = $request->get('tanggal_akhir', '');

        $category = $request->get('category', '');


        /*
        |--------------------------------------------------------------------------
        | QUERY BARANG TERLARIS
        |--------------------------------------------------------------------------
        */

        $query = SaleDetail::query()

            ->select(
                'product_id',
                DB::raw('SUM(qty) as total_terjual')
            )

            ->with([
                'product.category'
            ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER PERIODE TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai !== '') {

            $query->whereHas('sale', function ($q) use ($tanggalMulai) {

                $q->whereDate(
                    'tanggal',
                    '>=',
                    $tanggalMulai
                );

            });
        }


        if ($tanggalAkhir !== '') {

            $query->whereHas('sale', function ($q) use ($tanggalAkhir) {

                $q->whereDate(
                    'tanggal',
                    '<=',
                    $tanggalAkhir
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($category !== '') {

            $query->whereHas('product', function ($q) use ($category) {

                $q->where(
                    'category_id',
                    $category
                );

            });
        }


        /*
        |--------------------------------------------------------------------------
        | GROUP & URUTKAN
        |--------------------------------------------------------------------------
        */

        $products = $query

            ->groupBy('product_id')

            ->orderByDesc('total_terjual')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
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

        $totalQty = $products->sum(
            'total_terjual'
        );

        $produkTerlaris = $products->first();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.barang-terlaris',
            compact(
                'products',
                'categories',
                'tanggalMulai',
                'tanggalAkhir',
                'category',
                'totalProduk',
                'totalQty',
                'produkTerlaris'
            )
        );
    }


    /**
     * Cetak PDF
     */
    public function pdf(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;
        $category = $request->category;


        /*
        |--------------------------------------------------------------------------
        | QUERY BARANG TERLARIS
        |--------------------------------------------------------------------------
        */

        $query = SaleDetail::query()

            ->select(
                'product_id',
                DB::raw('SUM(qty) as total_terjual')
            )

            ->with([
                'product.category'
            ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER PERIODE TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai || $tanggalAkhir) {

            $query->whereHas('sale', function ($q) use (
                $tanggalMulai,
                $tanggalAkhir
            ) {

                if ($tanggalMulai) {

                    $q->whereDate(
                        'tanggal',
                        '>=',
                        $tanggalMulai
                    );

                }

                if ($tanggalAkhir) {

                    $q->whereDate(
                        'tanggal',
                        '<=',
                        $tanggalAkhir
                    );

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($category) {

            $query->whereHas(
                'product',
                function ($q) use ($category) {

                    $q->where(
                        'category_id',
                        $category
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | HASIL BARANG TERLARIS
        |--------------------------------------------------------------------------
        */

        $products = $query

            ->groupBy('product_id')

            ->orderByDesc('total_terjual')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalProduk = $products->count();

        $totalQty = $products->sum(
            'total_terjual'
        );

        $produkTerlaris = $products->first();


        /*
        |--------------------------------------------------------------------------
        | LABEL KATEGORI
        |--------------------------------------------------------------------------
        */

        $categoryLabel = 'Semua Kategori';

        if ($category) {

            $categoryLabel = Category::find($category)?->nama_kategori
                ?? 'Semua Kategori';

        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'admin.laporan.pdf.barang-terlaris',
            compact(
                'products',
                'totalProduk',
                'totalQty',
                'produkTerlaris',
                'tanggalMulai',
                'tanggalAkhir',
                'categoryLabel'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->download(
            'laporan-barang-terlaris.pdf'
        );
    }


    /**
     * Export Excel
     */
    public function excel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_akhir;
        $category = $request->category;


        /*
        |--------------------------------------------------------------------------
        | QUERY BARANG TERLARIS
        |--------------------------------------------------------------------------
        */

        $query = SaleDetail::query()

            ->select(
                'product_id',
                DB::raw('SUM(qty) as total_terjual')
            )

            ->with([
                'product.category'
            ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER PERIODE TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai || $tanggalAkhir) {

            $query->whereHas('sale', function ($q) use (
                $tanggalMulai,
                $tanggalAkhir
            ) {

                if ($tanggalMulai) {

                    $q->whereDate(
                        'tanggal',
                        '>=',
                        $tanggalMulai
                    );

                }

                if ($tanggalAkhir) {

                    $q->whereDate(
                        'tanggal',
                        '<=',
                        $tanggalAkhir
                    );

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($category) {

            $query->whereHas(
                'product',
                function ($q) use ($category) {

                    $q->where(
                        'category_id',
                        $category
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA BARANG TERLARIS
        |--------------------------------------------------------------------------
        */

        $products = $query

            ->groupBy('product_id')

            ->orderByDesc('total_terjual')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | LABEL KATEGORI
        |--------------------------------------------------------------------------
        */

        $categoryLabel = 'Semua Kategori';

        if ($category) {

            $categoryLabel =
                Category::find($category)?->nama_kategori
                ?? 'Semua Kategori';

        }


        /*
        |--------------------------------------------------------------------------
        | EXPORT EXCEL
        |--------------------------------------------------------------------------
        */

        return Excel::download(

            new BestSellingReportExport(
                $products,
                $tanggalMulai ?? '',
                $tanggalAkhir ?? '',
                $categoryLabel
            ),

            'laporan-barang-terlaris.xlsx'

        );
    }
}