<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\ReturnSale;
use App\Models\CashTransaction;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FinancialReportExport;
use Maatwebsite\Excel\Facades\Excel;

class FinancialReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LAPORAN KEUANGAN
    |--------------------------------------------------------------------------
    */

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

        $salesQuery = Sale::with([
            'user',
            'saleDetails.product'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL PENJUALAN
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai) {

            $salesQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }

        if ($tanggalAkhir) {

            $salesQuery->whereDate(
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

        $sales = $salesQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | QUERY RETUR
        |--------------------------------------------------------------------------
        */

        $returnsQuery = ReturnSale::with([
            'user',
            'sale',
            'details.product'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL RETUR
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai) {

            $returnsQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }

        if ($tanggalAkhir) {

            $returnsQuery->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA RETUR
        |--------------------------------------------------------------------------
        */

        $returns = $returnsQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | QUERY TRANSAKSI KAS
        |--------------------------------------------------------------------------
        */

        $cashQuery = CashTransaction::with(
            'returnSale'
        );


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL KAS
        |--------------------------------------------------------------------------
        */

        if ($tanggalMulai) {

            $cashQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }

        if ($tanggalAkhir) {

            $cashQuery->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        /*
        |--------------------------------------------------------------------------
        | DATA TRANSAKSI KAS
        |--------------------------------------------------------------------------
        */

        $cashTransactions = $cashQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ==============================================================
        | RINGKASAN PENJUALAN
        | ==============================================================
        |--------------------------------------------------------------------------
        */

        /*
        | PENJUALAN BRUTO
        |
        | Diambil dari subtotal sebelum diskon.
        */

        $totalPenjualanBruto = $sales->sum(
            'subtotal'
        );


        /*
        | TOTAL DISKON
        */

        $totalDiskon = $sales->sum(
            'diskon'
        );


        /*
        |--------------------------------------------------------------------------
        | PENJUALAN BERSIH
        |
        | Mengikuti total_bayar pada transaksi penjualan.
        |--------------------------------------------------------------------------
        */

        $totalPenjualanBersih = $sales->sum(
            'total_bayar'
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
                    $detail->qty
                    *
                    $hargaBeli;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | LABA KOTOR PENJUALAN
        |--------------------------------------------------------------------------
        */

        $labaKotor =
            $totalPenjualanBersih
            -
            $totalHpp;


        /*
        |--------------------------------------------------------------------------
        | ==============================================================
        | RINGKASAN RETUR
        | ==============================================================
        |--------------------------------------------------------------------------
        */

        /*
        | TOTAL SELURUH RETUR
        */

        $totalRetur = $returns->sum(
            'total_retur'
        );


        /*
        | TOTAL RETUR UANG
        */

        $totalReturUang = $returns
            ->where('return_type', 'uang')
            ->sum('total_retur');


        /*
        | TOTAL TUKAR BARANG
        |
        | Nilai barang yang dikembalikan.
        */

        $totalTukarBarang = $returns
            ->where('return_type', 'tukar')
            ->sum('total_retur');


        /*
        | TOTAL NILAI BARANG PENGGANTI
        */

        $totalNilaiPengganti = $returns
            ->where('return_type', 'tukar')
            ->sum('total_pengganti');


        /*
        | TOTAL SELISIH PEMBAYARAN
        */

        $totalSelisihPembayaran = $returns
            ->where('return_type', 'tukar')
            ->sum('selisih_bayar');


        /*
        |--------------------------------------------------------------------------
        | PENJUALAN SETELAH RETUR
        |--------------------------------------------------------------------------
        */

        $penjualanSetelahRetur =
            $totalPenjualanBersih
            -
            $totalRetur;


        /*
        |--------------------------------------------------------------------------
        | LABA SETELAH RETUR
        |--------------------------------------------------------------------------
        */

        $labaSetelahRetur =
            $penjualanSetelahRetur
            -
            $totalHpp;


        /*
        |--------------------------------------------------------------------------
        | ==============================================================
        | ARUS KAS
        | ==============================================================
        |--------------------------------------------------------------------------
        */

        /*
        | TOTAL KAS MASUK
        */

        $totalKasMasuk = $cashTransactions
            ->where('jenis', 'masuk')
            ->where('sumber', 'tukar_barang')
            ->sum('nominal');


        /*
        | TOTAL KAS KELUAR
        */

        $totalKasKeluar = $cashTransactions
            ->where('jenis', 'keluar')
            ->where('sumber', 'retur_uang')
            ->sum('nominal');


        /*
        | ARUS KAS BERSIH
        */

        $arusKasBersih =
            $totalKasMasuk
            -
            $totalKasKeluar;


        /*
        |--------------------------------------------------------------------------
        | ==============================================================
        | DATA VIEW
        | ==============================================================
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.keuangan',
            compact(

                /*
                | FILTER
                */

                'tanggalMulai',
                'tanggalAkhir',


                /*
                | PENJUALAN
                */

                'sales',

                'totalPenjualanBruto',

                'totalDiskon',

                'totalPenjualanBersih',

                'totalHpp',

                'labaKotor',

                'penjualanSetelahRetur',

                'labaSetelahRetur',


                /*
                | RETUR
                */

                'returns',

                'totalRetur',

                'totalReturUang',

                'totalTukarBarang',

                'totalNilaiPengganti',

                'totalSelisihPembayaran',


                /*
                | KAS
                */

                'cashTransactions',

                'totalKasMasuk',

                'totalKasKeluar',

                'arusKasBersih'

            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CETAK PDF
    |--------------------------------------------------------------------------
    */

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

        $salesQuery = Sale::with([
            'user',
            'saleDetails.product'
        ]);


        if ($tanggalMulai) {

            $salesQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }

        if ($tanggalAkhir) {

            $salesQuery->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        $sales = $salesQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | QUERY RETUR
        |--------------------------------------------------------------------------
        */

        $returnsQuery = ReturnSale::with([
            'user',
            'sale',
            'details.product'
        ]);


        if ($tanggalMulai) {

            $returnsQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }

        if ($tanggalAkhir) {

            $returnsQuery->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        $returns = $returnsQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | QUERY TRANSAKSI KAS
        |--------------------------------------------------------------------------
        */

        $cashQuery = CashTransaction::with(
            'returnSale'
        );


        if ($tanggalMulai) {

            $cashQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }

        if ($tanggalAkhir) {

            $cashQuery->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        $cashTransactions = $cashQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN PENJUALAN
        |--------------------------------------------------------------------------
        */

        $totalPenjualanBruto = $sales->sum(
            'subtotal'
        );


        $totalDiskon = $sales->sum(
            'diskon'
        );


        $totalPenjualanBersih = $sales->sum(
            'total_bayar'
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
                    $detail->qty
                    *
                    $hargaBeli;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | LABA KOTOR
        |--------------------------------------------------------------------------
        */

        $labaKotor =
            $totalPenjualanBersih
            -
            $totalHpp;


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN RETUR
        |--------------------------------------------------------------------------
        */

        $totalRetur = $returns->sum(
            'total_retur'
        );


        $totalReturUang = $returns
            ->where('return_type', 'uang')
            ->sum('total_retur');


        $totalTukarBarang = $returns
            ->where('return_type', 'tukar')
            ->sum('total_retur');


        $totalNilaiPengganti = $returns
            ->where('return_type', 'tukar')
            ->sum('total_pengganti');


        $totalSelisihPembayaran = $returns
            ->where('return_type', 'tukar')
            ->sum('selisih_bayar');


        /*
        |--------------------------------------------------------------------------
        | ARUS KAS
        |--------------------------------------------------------------------------
        */

        $totalKasMasuk = $cashTransactions
            ->where('jenis', 'masuk')
            ->where('sumber', 'tukar_barang')
            ->sum('nominal');


        $totalKasKeluar = $cashTransactions
            ->where('jenis', 'keluar')
            ->where('sumber', 'retur_uang')
            ->sum('nominal');


        $arusKasBersih =
            $totalKasMasuk
            -
            $totalKasKeluar;


        /*
        |--------------------------------------------------------------------------
        | ALIAS UNTUK PDF
        |--------------------------------------------------------------------------
        |
        | Disamakan dengan nama yang digunakan
        | pada Blade PDF.
        |
        */

        $totalPenjualan =
            $totalPenjualanBersih;


        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'admin.laporan.pdf.keuangan',
            compact(

                'sales',

                'returns',

                'cashTransactions',

                'tanggalMulai',

                'tanggalAkhir',

                'totalPenjualan',

                'totalPenjualanBruto',

                'totalPenjualanBersih',

                'totalDiskon',

                'totalHpp',

                'labaKotor',

                'totalRetur',

                'totalReturUang',

                'totalTukarBarang',

                'totalNilaiPengganti',

                'totalSelisihPembayaran',

                'totalKasMasuk',

                'totalKasKeluar',

                'arusKasBersih'

            )
        );


        return $pdf->download(
            'laporan-keuangan.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

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

        $salesQuery = Sale::with([
            'user',
            'saleDetails.product'
        ]);


        if ($tanggalMulai) {

            $salesQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }


        if ($tanggalAkhir) {

            $salesQuery->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        $sales = $salesQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | QUERY RETUR
        |--------------------------------------------------------------------------
        */

        $returnsQuery = ReturnSale::with([
            'user',
            'sale',
            'details.product'
        ]);


        if ($tanggalMulai) {

            $returnsQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }


        if ($tanggalAkhir) {

            $returnsQuery->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        $returns = $returnsQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | QUERY TRANSAKSI KAS
        |--------------------------------------------------------------------------
        */

        $cashQuery = CashTransaction::query();


        if ($tanggalMulai) {

            $cashQuery->whereDate(
                'tanggal',
                '>=',
                $tanggalMulai
            );

        }


        if ($tanggalAkhir) {

            $cashQuery->whereDate(
                'tanggal',
                '<=',
                $tanggalAkhir
            );

        }


        $cashTransactions = $cashQuery
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN PENJUALAN
        |--------------------------------------------------------------------------
        */

        /*
        * Penjualan Bruto
        * = subtotal seluruh transaksi penjualan
        */

        $totalPenjualanBruto =
            $sales->sum('subtotal');


        /*
        * Total Diskon
        */

        $totalDiskon =
            $sales->sum('diskon');


        /*
        * Penjualan Bersih
        * = total_bayar seluruh transaksi penjualan
        */

        $totalPenjualanBersih =
            $sales->sum('total_bayar');


        /*
        * Tetap disediakan sebagai totalPenjualan
        * agar kompatibel dengan struktur laporan.
        */

        $totalPenjualan =
            $totalPenjualanBersih;


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
                    $detail->qty
                    *
                    $hargaBeli;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | LABA KOTOR
        |--------------------------------------------------------------------------
        */

        $labaKotor =
            $totalPenjualanBersih
            -
            $totalHpp;


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN RETUR
        |--------------------------------------------------------------------------
        */

        /*
        * Total seluruh retur
        */

        $totalRetur =
            $returns->sum('total_retur');


        /*
        * Retur Uang
        */

        $totalReturUang =
            $returns
                ->where('return_type', 'uang')
                ->sum('total_retur');


        /*
        * Tukar Barang
        */

        $totalTukarBarang =
            $returns
                ->where('return_type', 'tukar')
                ->sum('total_retur');


        /*
        * Nilai Barang Pengganti
        */

        $totalNilaiPengganti =
            $returns
                ->where('return_type', 'tukar')
                ->sum('total_pengganti');


        /*
        * Selisih Pembayaran
        */

        $totalSelisihPembayaran =
            $returns
                ->where('return_type', 'tukar')
                ->sum('selisih_bayar');


        /*
        |--------------------------------------------------------------------------
        | ARUS KAS
        |--------------------------------------------------------------------------
        */

        /*
        * Kas Masuk
        */

        $totalKasMasuk =
            $cashTransactions
                ->where('jenis', 'masuk')
                ->sum('nominal');


        /*
        * Kas Keluar
        */

        $totalKasKeluar =
            $cashTransactions
                ->where('jenis', 'keluar')
                ->sum('nominal');


        /*
        * Arus Kas Bersih
        */

        $arusKasBersih =
            $totalKasMasuk
            -
            $totalKasKeluar;


        /*
        |--------------------------------------------------------------------------
        | EXPORT EXCEL
        |--------------------------------------------------------------------------
        */

        return Excel::download(

            new FinancialReportExport(

                $sales,

                $returns,

                $cashTransactions,

                $tanggalMulai,

                $tanggalAkhir,

                $totalPenjualan,

                $totalPenjualanBruto,

                $totalPenjualanBersih,

                $totalDiskon,

                $totalHpp,

                $labaKotor,

                $totalRetur,

                $totalReturUang,

                $totalTukarBarang,

                $totalNilaiPengganti,

                $totalSelisihPembayaran,

                $totalKasMasuk,

                $totalKasKeluar,

                $arusKasBersih

            ),

            'laporan-keuangan.xlsx'

        );
    }
}