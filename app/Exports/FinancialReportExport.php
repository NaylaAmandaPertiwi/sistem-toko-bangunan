<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FinancialReportExport implements FromView
{
    protected $sales;
    protected $returns;
    protected $cashTransactions;

    protected $tanggalMulai;
    protected $tanggalAkhir;

    /*
    |--------------------------------------------------------------------------
    | PENJUALAN DAN LABA
    |--------------------------------------------------------------------------
    */

    protected $totalPenjualan;
    protected $totalPenjualanBruto;
    protected $totalPenjualanBersih;
    protected $totalDiskon;
    protected $uangPenjualan;

    protected $totalHpp;
    protected $labaKotor;
    protected $totalBebanOperasional;
    protected $labaBersih;


    /*
    |--------------------------------------------------------------------------
    | RETUR
    |--------------------------------------------------------------------------
    */

    protected $totalReturUang;
    protected $jumlahTukarBarang;
    protected $nilaiBarangDikembalikan;
    protected $nilaiBarangPengganti;
    protected $selisihTukarBarang;


    /*
    |--------------------------------------------------------------------------
    | KAS
    |--------------------------------------------------------------------------
    */

    protected $kasMasukPenjualan;
    protected $kasMasukDariTukar;
    protected $totalKasMasuk;

    protected $kasKeluarDariReturUang;
    protected $kasKeluarDariBebanOperasional;
    protected $totalKasKeluar;

    protected $arusKasBersih;


    /*
    |--------------------------------------------------------------------------
    | SALDO KAS
    |--------------------------------------------------------------------------
    */

    protected $saldoAwalKas;
    protected $saldoAkhirKas;


    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(
        $sales,
        $returns,
        $cashTransactions,

        $tanggalMulai,
        $tanggalAkhir,

        /*
        |----------------------------------------------------------------------
        | Penjualan dan Laba
        |----------------------------------------------------------------------
        */

        $totalPenjualan,
        $totalPenjualanBruto,
        $totalPenjualanBersih,
        $totalDiskon,
        $uangPenjualan,

        $totalHpp,
        $labaKotor,
        $totalBebanOperasional,
        $labaBersih,

        /*
        |----------------------------------------------------------------------
        | Retur
        |----------------------------------------------------------------------
        */

        $totalReturUang,
        $jumlahTukarBarang,
        $nilaiBarangDikembalikan,
        $nilaiBarangPengganti,
        $selisihTukarBarang,

        /*
        |----------------------------------------------------------------------
        | Kas
        |----------------------------------------------------------------------
        */

        $kasMasukDariTukar,
        $kasKeluarDariReturUang,
        $arusKasBersih,

        /*
        |----------------------------------------------------------------------
        | Saldo Kas
        |----------------------------------------------------------------------
        */

        $saldoAwalKas,
        $kasMasukPenjualan,
        $totalKasMasuk,
        $kasKeluarDariBebanOperasional,
        $totalKasKeluar,
        $saldoAkhirKas
    ) {

        /*
        |--------------------------------------------------------------------------
        | DATA DASAR
        |--------------------------------------------------------------------------
        */

        $this->sales =
            $sales;

        $this->returns =
            $returns;

        $this->cashTransactions =
            $cashTransactions;


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        $this->tanggalMulai =
            $tanggalMulai;

        $this->tanggalAkhir =
            $tanggalAkhir;


        /*
        |--------------------------------------------------------------------------
        | PENJUALAN DAN LABA
        |--------------------------------------------------------------------------
        */

        $this->totalPenjualan =
            $totalPenjualan;

        $this->totalPenjualanBruto =
            $totalPenjualanBruto;

        $this->totalPenjualanBersih =
            $totalPenjualanBersih;

        $this->totalDiskon =
            $totalDiskon;

        $this->uangPenjualan =
            $uangPenjualan;

        $this->totalHpp =
            $totalHpp;

        $this->labaKotor =
            $labaKotor;

        $this->totalBebanOperasional =
            $totalBebanOperasional;

        $this->labaBersih =
            $labaBersih;


        /*
        |--------------------------------------------------------------------------
        | RETUR
        |--------------------------------------------------------------------------
        */

        $this->totalReturUang =
            $totalReturUang;

        $this->jumlahTukarBarang =
            $jumlahTukarBarang;

        $this->nilaiBarangDikembalikan =
            $nilaiBarangDikembalikan;

        $this->nilaiBarangPengganti =
            $nilaiBarangPengganti;

        $this->selisihTukarBarang =
            $selisihTukarBarang;


        /*
        |--------------------------------------------------------------------------
        | KAS
        |--------------------------------------------------------------------------
        */

        $this->kasMasukDariTukar =
            $kasMasukDariTukar;

        $this->kasKeluarDariReturUang =
            $kasKeluarDariReturUang;

        $this->arusKasBersih =
            $arusKasBersih;


        /*
        |--------------------------------------------------------------------------
        | SALDO KAS
        |--------------------------------------------------------------------------
        */

        $this->saldoAwalKas =
            $saldoAwalKas;

        $this->kasMasukPenjualan =
            $kasMasukPenjualan;

        $this->totalKasMasuk =
            $totalKasMasuk;

        $this->kasKeluarDariBebanOperasional =
            $kasKeluarDariBebanOperasional;

        $this->totalKasKeluar =
            $totalKasKeluar;

        $this->saldoAkhirKas =
            $saldoAkhirKas;
    }


    /*
    |--------------------------------------------------------------------------
    | VIEW EXCEL
    |--------------------------------------------------------------------------
    */

    public function view(): View
    {
        return view(
            'admin.laporan.excel.keuangan',
            [

                /*
                |--------------------------------------------------------------------------
                | Data transaksi
                |--------------------------------------------------------------------------
                */

                'sales' =>
                    $this->sales,

                'returns' =>
                    $this->returns,

                'cashTransactions' =>
                    $this->cashTransactions,


                /*
                |--------------------------------------------------------------------------
                | Filter tanggal
                |--------------------------------------------------------------------------
                */

                'tanggalMulai' =>
                    $this->tanggalMulai,

                'tanggalAkhir' =>
                    $this->tanggalAkhir,


                /*
                |--------------------------------------------------------------------------
                | Penjualan
                |--------------------------------------------------------------------------
                */

                'totalPenjualan' =>
                    $this->totalPenjualan,

                'totalPenjualanBruto' =>
                    $this->totalPenjualanBruto,

                'totalPenjualanBersih' =>
                    $this->totalPenjualanBersih,

                'totalDiskon' =>
                    $this->totalDiskon,

                'uangPenjualan' =>
                    $this->uangPenjualan,


                /*
                |--------------------------------------------------------------------------
                | Laba
                |--------------------------------------------------------------------------
                */

                'totalHpp' =>
                    $this->totalHpp,

                'labaKotor' =>
                    $this->labaKotor,

                'totalBebanOperasional' =>
                    $this->totalBebanOperasional,

                'labaBersih' =>
                    $this->labaBersih,


                /*
                |--------------------------------------------------------------------------
                | Retur
                |--------------------------------------------------------------------------
                */

                'totalReturUang' =>
                    $this->totalReturUang,

                'jumlahTukarBarang' =>
                    $this->jumlahTukarBarang,

                'nilaiBarangDikembalikan' =>
                    $this->nilaiBarangDikembalikan,

                'nilaiBarangPengganti' =>
                    $this->nilaiBarangPengganti,

                'selisihTukarBarang' =>
                    $this->selisihTukarBarang,


                /*
                |--------------------------------------------------------------------------
                | Kas Masuk
                |--------------------------------------------------------------------------
                */

                'kasMasukPenjualan' =>
                    $this->kasMasukPenjualan,

                'kasMasukDariTukar' =>
                    $this->kasMasukDariTukar,

                'totalKasMasuk' =>
                    $this->totalKasMasuk,


                /*
                |--------------------------------------------------------------------------
                | Kas Keluar
                |--------------------------------------------------------------------------
                */

                'kasKeluarDariReturUang' =>
                    $this->kasKeluarDariReturUang,

                'kasKeluarDariBebanOperasional' =>
                    $this->kasKeluarDariBebanOperasional,

                'totalKasKeluar' =>
                    $this->totalKasKeluar,


                /*
                |--------------------------------------------------------------------------
                | Arus Kas
                |--------------------------------------------------------------------------
                */

                'arusKasBersih' =>
                    $this->arusKasBersih,


                /*
                |--------------------------------------------------------------------------
                | Saldo Kas
                |--------------------------------------------------------------------------
                */

                'saldoAwalKas' =>
                    $this->saldoAwalKas,

                'saldoAkhirKas' =>
                    $this->saldoAkhirKas,

            ]
        );
    }
}