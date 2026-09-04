<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\ReturnSale;
use App\Models\CashTransaction;
use App\Models\BebanOperasional;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FinancialReportExport;
use Maatwebsite\Excel\Facades\Excel;

class FinancialReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN KEUANGAN
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
    | MENGAMBIL DATA LAPORAN KEUANGAN
    |--------------------------------------------------------------------------
    */

    private function getFinancialData(Request $request)
    {
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
        |
        | cash_transactions digunakan untuk:
        |
        | 1. Saldo Awal Kas
        | 2. Selisih pembayaran tukar barang
        | 3. Retur uang
        |
        | Saldo awal TIDAK akan dihitung sebagai Kas Masuk periode.
        |
        */

        $cashQuery = CashTransaction::with('returnSale');

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
        | DATA BEBAN OPERASIONAL
        |--------------------------------------------------------------------------
        */

        $bebanOperasionals = BebanOperasional::query()

            ->when(
                $tanggalMulai,
                function ($query) use ($tanggalMulai) {

                    $query->whereDate(
                        'tanggal',
                        '>=',
                        $tanggalMulai
                    );

                }
            )

            ->when(
                $tanggalAkhir,
                function ($query) use ($tanggalAkhir) {

                    $query->whereDate(
                        'tanggal',
                        '<=',
                        $tanggalAkhir
                    );

                }
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN PENJUALAN
        |--------------------------------------------------------------------------
        */

        $totalPenjualanBruto =
            $sales->sum('subtotal');


        $totalDiskon =
            $sales->sum('diskon');


        $totalPenjualanBersih =
            $totalPenjualanBruto
            -
            $totalDiskon;


        /*
        |--------------------------------------------------------------------------
        | UANG PENJUALAN
        |--------------------------------------------------------------------------
        |
        | total_bayar adalah nilai transaksi yang benar-benar menjadi
        | penerimaan penjualan.
        |
        | Jangan menggunakan field "bayar" karena field tersebut
        | merupakan uang yang diberikan pelanggan sebelum dikurangi
        | kembalian.
        |
        */

        $uangPenjualan =
            $sales->sum('total_bayar');


        $totalPenjualan =
            $uangPenjualan;


        /*
        |--------------------------------------------------------------------------
        | HITUNG HPP
        |--------------------------------------------------------------------------
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
        */

        $totalBebanOperasional =
            $bebanOperasionals->sum('nominal');


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

        $totalReturUang =
            $returns
                ->where('return_type', 'uang')
                ->sum('total_retur');


        $jumlahTukarBarang =
            $returns
                ->where('return_type', 'tukar')
                ->count();


        $nilaiBarangDikembalikan =
            $returns
                ->where('return_type', 'tukar')
                ->sum('total_retur');


        $nilaiBarangPengganti =
            $returns
                ->where('return_type', 'tukar')
                ->sum('total_pengganti');


        $selisihTukarBarang =
            $returns
                ->where('return_type', 'tukar')
                ->sum('selisih_bayar');


        /*
        |--------------------------------------------------------------------------
        | KAS MASUK DARI TUKAR BARANG
        |--------------------------------------------------------------------------
        |
        | Hanya transaksi:
        |
        | jenis  = masuk
        | sumber = tukar_barang
        |
        | Saldo awal tidak ikut dihitung di sini.
        |
        */

        $kasMasukDariTukar =
            $cashTransactions
                ->where('jenis', 'masuk')
                ->where('sumber', 'tukar_barang')
                ->sum('nominal');


        /*
        |--------------------------------------------------------------------------
        | KAS KELUAR DARI RETUR UANG
        |--------------------------------------------------------------------------
        */

        $kasKeluarDariReturUang =
            $cashTransactions
                ->where('jenis', 'keluar')
                ->where('sumber', 'retur_uang')
                ->sum('nominal');


        /*
        |--------------------------------------------------------------------------
        | KAS KELUAR DARI BEBAN OPERASIONAL
        |--------------------------------------------------------------------------
        |
        | Beban operasional disimpan pada tabel beban_operasionals,
        | bukan pada cash_transactions.
        |
        */

        $kasKeluarDariBebanOperasional =
            $totalBebanOperasional;


        /*
        |--------------------------------------------------------------------------
        | TOTAL KAS MASUK PERIODE
        |--------------------------------------------------------------------------
        */

        $kasMasukPenjualan =
            $uangPenjualan;


        $totalKasMasuk =
            $kasMasukPenjualan
            +
            $kasMasukDariTukar;


        /*
        |--------------------------------------------------------------------------
        | TOTAL KAS KELUAR PERIODE
        |--------------------------------------------------------------------------
        */

        $totalKasKeluar =
            $kasKeluarDariReturUang
            +
            $kasKeluarDariBebanOperasional;


        /*
        |--------------------------------------------------------------------------
        | ARUS KAS BERSIH
        |--------------------------------------------------------------------------
        */

        $arusKasBersih =
            $totalKasMasuk
            -
            $totalKasKeluar;


        /*
        |--------------------------------------------------------------------------
        | SALDO AWAL KAS
        |--------------------------------------------------------------------------
        |
        | Konsep:
        |
        | Saldo Awal Kas =
        | uang yang sudah tersedia sebelum periode laporan.
        |
        | Jika laporan menggunakan tanggal mulai, maka:
        |
        | Saldo Awal =
        | Saldo awal yang telah dicatat
        | +
        | seluruh transaksi kas sebelum tanggal mulai.
        |
        | Transaksi "saldo_awal" tidak dimasukkan sebagai Kas Masuk.
        | Ia hanya menjadi dasar saldo awal.
        |
        */

        $saldoAwalKas = 0;


        if ($tanggalMulai) {

            /*
            |--------------------------------------------------------------------------
            | 1. SALDO AWAL YANG SUDAH DICATAT
            |--------------------------------------------------------------------------
            |
            | Mengambil transaksi saldo_awal sampai sebelum / pada
            | tanggal mulai laporan.
            |
            */

            $saldoAwalTercatat =
                CashTransaction::query()
                    ->where('sumber', 'saldo_awal')
                    ->whereDate(
                        'tanggal',
                        '<=',
                        $tanggalMulai
                    )
                    ->sum('nominal');


            /*
            |--------------------------------------------------------------------------
            | 2. PENJUALAN SEBELUM PERIODE
            |--------------------------------------------------------------------------
            */

            $kasPenjualanSebelumPeriode =
                Sale::query()
                    ->whereDate(
                        'tanggal',
                        '<',
                        $tanggalMulai
                    )
                    ->sum('total_bayar');


            /*
            |--------------------------------------------------------------------------
            | 3. TRANSAKSI KAS SEBELUM PERIODE
            |--------------------------------------------------------------------------
            |
            | Saldo awal tidak dihitung lagi di sini karena sudah
            | diambil pada $saldoAwalTercatat.
            |
            */

            $cashSebelumPeriode =
                CashTransaction::query()
                    ->whereDate(
                        'tanggal',
                        '<',
                        $tanggalMulai
                    )
                    ->where('sumber', '!=', 'saldo_awal')
                    ->get();


            $kasMasukSebelumPeriode =
                $cashSebelumPeriode
                    ->where('jenis', 'masuk')
                    ->sum('nominal');


            $kasKeluarSebelumPeriode =
                $cashSebelumPeriode
                    ->where('jenis', 'keluar')
                    ->sum('nominal');


            /*
            |--------------------------------------------------------------------------
            | 4. BEBAN OPERASIONAL SEBELUM PERIODE
            |--------------------------------------------------------------------------
            */

            $bebanSebelumPeriode =
                BebanOperasional::query()
                    ->whereDate(
                        'tanggal',
                        '<',
                        $tanggalMulai
                    )
                    ->sum('nominal');


            /*
            |--------------------------------------------------------------------------
            | 5. HITUNG SALDO AWAL
            |--------------------------------------------------------------------------
            */

            $saldoAwalKas =

                $saldoAwalTercatat

                +

                $kasPenjualanSebelumPeriode

                +

                $kasMasukSebelumPeriode

                -

                $kasKeluarSebelumPeriode

                -

                $bebanSebelumPeriode;

        } else {

            /*
            |--------------------------------------------------------------------------
            | JIKA TIDAK ADA TANGGAL MULAI
            |--------------------------------------------------------------------------
            |
            | "Semua Tanggal":
            |
            | Saldo awal diambil dari saldo awal yang dicatat.
            |
            | Seluruh transaksi setelah saldo awal akan dihitung
            | sebagai pergerakan kas periode.
            |
            */

            $saldoAwalKas =
                CashTransaction::query()
                    ->where('sumber', 'saldo_awal')
                    ->sum('nominal');

        }


        /*
        |--------------------------------------------------------------------------
        | SALDO AKHIR KAS
        |--------------------------------------------------------------------------
        */

        $saldoAkhirKas =
            $saldoAwalKas
            +
            $arusKasBersih;


        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK VIEW
        |--------------------------------------------------------------------------
        */

        return compact(

            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            'tanggalMulai',
            'tanggalAkhir',


            /*
            |--------------------------------------------------------------------------
            | PENJUALAN
            |--------------------------------------------------------------------------
            */

            'sales',

            'totalPenjualan',

            'totalPenjualanBruto',

            'totalPenjualanBersih',

            'totalDiskon',

            'uangPenjualan',


            /*
            |--------------------------------------------------------------------------
            | LABA
            |--------------------------------------------------------------------------
            */

            'totalHpp',

            'labaKotor',

            'bebanOperasionals',

            'totalBebanOperasional',

            'labaBersih',


            /*
            |--------------------------------------------------------------------------
            | RETUR
            |--------------------------------------------------------------------------
            */

            'returns',

            'totalReturUang',

            'jumlahTukarBarang',

            'nilaiBarangDikembalikan',

            'nilaiBarangPengganti',

            'selisihTukarBarang',


            /*
            |--------------------------------------------------------------------------
            | TRANSAKSI KAS
            |--------------------------------------------------------------------------
            */

            'cashTransactions',

            'kasMasukPenjualan',

            'kasMasukDariTukar',

            'totalKasMasuk',

            'kasKeluarDariReturUang',

            'kasKeluarDariBebanOperasional',

            'totalKasKeluar',

            'arusKasBersih',


            /*
            |--------------------------------------------------------------------------
            | SALDO KAS
            |--------------------------------------------------------------------------
            */

            'saldoAwalKas',

            'saldoAkhirKas'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
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

                $data['arusKasBersih'],

                $data['saldoAwalKas'],

                $data['kasMasukPenjualan'],

                $data['totalKasMasuk'],

                $data['kasKeluarDariBebanOperasional'],

                $data['totalKasKeluar'],

                $data['saldoAkhirKas']

            ),

            'laporan-keuangan.xlsx'
        );
    }
}