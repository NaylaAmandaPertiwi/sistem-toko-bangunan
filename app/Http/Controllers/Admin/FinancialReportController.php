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
        $data = $this->getFinancialData($request);

        return view(
            'admin.laporan.keuangan',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MENGAMBIL DATA DAN PERHITUNGAN LAPORAN KEUANGAN
    |--------------------------------------------------------------------------
    */

    private function getFinancialData(Request $request)
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
        | DATA PENJUALAN
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
        | DATA RETUR
        |--------------------------------------------------------------------------
        */

        $returnsQuery = ReturnSale::with([
            'user',
            'sale',
            'details.product',
            'exchangeDetails.product'
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
        | DATA TRANSAKSI KAS
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

        /*
        | Penjualan Bruto
        | = seluruh subtotal sebelum diskon
        */

        $totalPenjualanBruto = $sales->sum('subtotal');


        /*
        | Total Diskon
        */

        $totalDiskon = $sales->sum('diskon');


        /*
        | Penjualan Bersih
        | = Penjualan Bruto - Total Diskon
        */

        $totalPenjualanBersih =
            $totalPenjualanBruto
            -
            $totalDiskon;


        /*
        | Uang Penjualan
        |
        | Diambil dari total_bayar yang benar-benar harus
        | dibayarkan pelanggan setelah diskon.
        */

        $uangPenjualan = $sales->sum('total_bayar');


        /*
        |--------------------------------------------------------------------------
        | HPP
        |--------------------------------------------------------------------------
        |
        | HPP menggunakan harga_beli yang disimpan pada
        | sale_details, bukan harga_beli produk saat ini.
        |
        */

        $totalHpp = 0;

        foreach ($sales as $sale) {

            foreach ($sale->saleDetails as $detail) {

                $totalHpp +=
                    $detail->qty
                    *
                    $detail->harga_beli;
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
        | BEBAN OPERASIONAL
        |--------------------------------------------------------------------------
        |
        | Saat ini sistem belum mempunyai tabel pencatatan
        | beban operasional, sehingga nilainya 0.
        |
        */

        $totalBebanOperasional = 0;


        /*
        |--------------------------------------------------------------------------
        | LABA BERSIH
        |--------------------------------------------------------------------------
        */

        $labaBersih =
            $labaKotor
            -
            $totalBebanOperasional;


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN RETUR
        |--------------------------------------------------------------------------
        */

        /*
        | Total Retur Uang
        */

        $totalReturUang = $returns
            ->where('return_type', 'uang')
            ->sum('total_retur');


        /*
        | Jumlah Tukar Barang
        |
        | Menghitung jumlah transaksi retur dengan
        | jenis tukar barang.
        */

        $jumlahTukarBarang = $returns
            ->where('return_type', 'tukar')
            ->count();


        /*
        | Nilai Barang Dikembalikan
        |
        | Merupakan nilai barang yang dikembalikan
        | pada transaksi tukar barang.
        */

        $nilaiBarangDikembalikan = $returns
            ->where('return_type', 'tukar')
            ->sum('total_retur');


        /*
        | Nilai Barang Pengganti
        */

        $nilaiBarangPengganti = $returns
            ->where('return_type', 'tukar')
            ->sum('total_pengganti');


        /*
        | Selisih Tukar Barang
        |
        | Nilai pengganti - nilai barang dikembalikan.
        */

        $selisihTukarBarang = $returns
            ->where('return_type', 'tukar')
            ->sum('selisih_bayar');


        /*
        |--------------------------------------------------------------------------
        | KAS
        |--------------------------------------------------------------------------
        */

        /*
        | Kas Masuk dari Tukar
        |
        | Hanya mengambil kas masuk yang berasal dari
        | selisih pembayaran tukar barang.
        */

        $kasMasukDariTukar = $cashTransactions
            ->where('jenis', 'masuk')
            ->where('sumber', 'tukar_barang')
            ->sum('nominal');


        /*
        | Kas Keluar dari Retur Uang
        */

        $kasKeluarDariReturUang = $cashTransactions
            ->where('jenis', 'keluar')
            ->where('sumber', 'retur_uang')
            ->sum('nominal');


        /*
        | Arus Kas Bersih
        */

        $arusKasBersih =
            $kasMasukDariTukar
            -
            $kasKeluarDariReturUang;


        /*
        |--------------------------------------------------------------------------
        | ALIAS
        |--------------------------------------------------------------------------
        |
        | Tetap disediakan agar bagian PDF/Excel lama
        | yang menggunakan nama totalPenjualan tidak error.
        |
        */

        $totalPenjualan = $uangPenjualan;


        /*
        |--------------------------------------------------------------------------
        | DATA YANG DIKIRIM KE VIEW
        |--------------------------------------------------------------------------
        */

        return compact(

            /*
            | Filter
            */

            'tanggalMulai',
            'tanggalAkhir',


            /*
            | Penjualan
            */

            'sales',

            'totalPenjualanBruto',

            'totalDiskon',

            'totalPenjualanBersih',

            'uangPenjualan',

            'totalPenjualan',

            'totalHpp',

            'labaKotor',

            'totalBebanOperasional',

            'labaBersih',


            /*
            | Retur
            */

            'returns',

            'totalReturUang',

            'jumlahTukarBarang',

            'nilaiBarangDikembalikan',

            'nilaiBarangPengganti',

            'selisihTukarBarang',


            /*
            | Kas
            */

            'cashTransactions',

            'kasMasukDariTukar',

            'kasKeluarDariReturUang',

            'arusKasBersih'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CETAK PDF
    |--------------------------------------------------------------------------
    */

    public function pdf(Request $request)
    {
        $data = $this->getFinancialData($request);

        $pdf = Pdf::loadView(
            'admin.laporan.pdf.keuangan',
            $data
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
        $data = $this->getFinancialData($request);

        return Excel::download(

            new FinancialReportExport(

                $data['sales'],

                $data['returns'],

                $data['cashTransactions'],

                $data['tanggalMulai'],

                $data['tanggalAkhir'],

                $data['totalPenjualan'],

                $data['totalPenjualanBruto'],

                $data['totalPenjualanBersih'],

                $data['totalDiskon'],

                $data['uangPenjualan'],

                $data['totalHpp'],

                $data['labaKotor'],

                $data['totalBebanOperasional'],

                $data['labaBersih'],

                $data['totalReturUang'],

                $data['jumlahTukarBarang'],

                $data['nilaiBarangDikembalikan'],

                $data['nilaiBarangPengganti'],

                $data['selisihTukarBarang'],

                $data['kasMasukDariTukar'],

                $data['kasKeluarDariReturUang'],

                $data['arusKasBersih']

            ),

            'laporan-keuangan.xlsx'
        );
    }
}