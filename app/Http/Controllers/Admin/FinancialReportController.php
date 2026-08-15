<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FinancialReportExport;
use Maatwebsite\Excel\Facades\Excel;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $request->tanggal_mulai;

        $tanggalAkhir = $request->tanggal_akhir;


        /*
        |--------------------------------------------------------------------------
        | QUERY PENJUALAN
        |--------------------------------------------------------------------------
        */

        $query = Sale::with([
            'user',
            'saleDetails.product'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai) {

            $query->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL AKHIR
        |--------------------------------------------------------------------------
        */

        if ($tanggalAkhir) {

            $query->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA PENJUALAN
        |--------------------------------------------------------------------------
        */

        $sales = $query

            ->orderByDesc('tanggal')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENJUALAN
        |--------------------------------------------------------------------------
        */

        $totalPenjualan = $sales->sum(
            'total_bayar'
        );


        /*
        |--------------------------------------------------------------------------
        | TOTAL DISKON
        |--------------------------------------------------------------------------
        */

        $totalDiskon = $sales->sum(
            'diskon'
        );


        /*
        |--------------------------------------------------------------------------
        | TOTAL HPP
        |--------------------------------------------------------------------------
        */

        $totalHpp = 0;


        foreach ($sales as $sale) {

            foreach ($sale->saleDetails as $detail) {

                $hargaBeli =
                    $detail->product->harga_beli ?? 0;

                $totalHpp +=
                    $detail->qty * $hargaBeli;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | LABA KOTOR
        |--------------------------------------------------------------------------
        */

        $labaKotor =
            $totalPenjualan - $totalHpp;


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.keuangan',
            compact(
                'sales',
                'tanggalMulai',
                'tanggalAkhir',
                'totalPenjualan',
                'totalDiskon',
                'totalHpp',
                'labaKotor'
            )
        );
    }

    public function pdf(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $request->tanggal_mulai;

        $tanggalAkhir = $request->tanggal_akhir;


        /*
        |--------------------------------------------------------------------------
        | QUERY PENJUALAN
        |--------------------------------------------------------------------------
        */

        $query = Sale::with([
            'user',
            'saleDetails.product'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai) {

            $query->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL AKHIR
        |--------------------------------------------------------------------------
        */

        if ($tanggalAkhir) {

            $query->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA PENJUALAN
        |--------------------------------------------------------------------------
        */

        $sales = $query

            ->orderByDesc('tanggal')

            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENJUALAN
        |--------------------------------------------------------------------------
        */

        $totalPenjualan = $sales->sum(
            'total_bayar'
        );


        /*
        |--------------------------------------------------------------------------
        | TOTAL DISKON
        |--------------------------------------------------------------------------
        */

        $totalDiskon = $sales->sum(
            'diskon'
        );


        /*
        |--------------------------------------------------------------------------
        | TOTAL HPP
        |--------------------------------------------------------------------------
        */

        $totalHpp = 0;


        foreach ($sales as $sale) {

            foreach ($sale->saleDetails as $detail) {

                $hargaBeli =
                    $detail->product->harga_beli ?? 0;

                $totalHpp +=
                    $detail->qty * $hargaBeli;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | LABA KOTOR
        |--------------------------------------------------------------------------
        */

        $labaKotor =
            $totalPenjualan - $totalHpp;


        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'admin.laporan.pdf.keuangan',
            compact(
                'sales',
                'tanggalMulai',
                'tanggalAkhir',
                'totalPenjualan',
                'totalDiskon',
                'totalHpp',
                'labaKotor'
            )
        );


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->download(
            'laporan-keuangan.pdf'
        );
    }

    public function excel(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        $tanggalMulai =
            $request->tanggal_mulai;

        $tanggalAkhir =
            $request->tanggal_akhir;


        /*
        |--------------------------------------------------------------------------
        | QUERY PENJUALAN
        |--------------------------------------------------------------------------
        */

        $query = Sale::with([
            'user',
            'saleDetails.product'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai) {

            $query->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL AKHIR
        |--------------------------------------------------------------------------
        */

        if ($tanggalAkhir) {

            $query->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA PENJUALAN
        |--------------------------------------------------------------------------
        */

        $sales = $query
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PENJUALAN
        |--------------------------------------------------------------------------
        */

        $totalPenjualan =
            $sales->sum('total_bayar');


        /*
        |--------------------------------------------------------------------------
        | TOTAL DISKON
        |--------------------------------------------------------------------------
        */

        $totalDiskon =
            $sales->sum('diskon');


        /*
        |--------------------------------------------------------------------------
        | TOTAL HPP
        |--------------------------------------------------------------------------
        */

        $totalHpp = 0;


        foreach ($sales as $sale) {

            foreach ($sale->saleDetails as $detail) {

                $hargaBeli =
                    $detail->product->harga_beli ?? 0;

                $totalHpp +=
                    $detail->qty * $hargaBeli;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | LABA KOTOR
        |--------------------------------------------------------------------------
        */

        $labaKotor =
            $totalPenjualan - $totalHpp;


        /*
        |--------------------------------------------------------------------------
        | EXPORT EXCEL
        |--------------------------------------------------------------------------
        */

        return Excel::download(

            new FinancialReportExport(
                $sales,
                $tanggalMulai,
                $tanggalAkhir,
                $totalPenjualan,
                $totalDiskon,
                $totalHpp,
                $labaKotor
            ),

            'laporan-keuangan.xlsx'

        );
    }


}