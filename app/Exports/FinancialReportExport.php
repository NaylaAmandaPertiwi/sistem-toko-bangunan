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

    protected $totalPenjualan;
    protected $totalPenjualanBruto;
    protected $totalPenjualanBersih;
    protected $totalDiskon;
    protected $totalHpp;
    protected $labaKotor;

    protected $totalRetur;
    protected $totalReturUang;
    protected $totalTukarBarang;
    protected $totalNilaiPengganti;
    protected $totalSelisihPembayaran;

    protected $totalKasMasuk;
    protected $totalKasKeluar;
    protected $arusKasBersih;


    public function __construct(
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
    ) {

        $this->sales =
            $sales;

        $this->returns =
            $returns;

        $this->cashTransactions =
            $cashTransactions;


        $this->tanggalMulai =
            $tanggalMulai;

        $this->tanggalAkhir =
            $tanggalAkhir;


        $this->totalPenjualan =
            $totalPenjualan;

        $this->totalPenjualanBruto =
            $totalPenjualanBruto;

        $this->totalPenjualanBersih =
            $totalPenjualanBersih;

        $this->totalDiskon =
            $totalDiskon;

        $this->totalHpp =
            $totalHpp;

        $this->labaKotor =
            $labaKotor;


        $this->totalRetur =
            $totalRetur;

        $this->totalReturUang =
            $totalReturUang;

        $this->totalTukarBarang =
            $totalTukarBarang;

        $this->totalNilaiPengganti =
            $totalNilaiPengganti;

        $this->totalSelisihPembayaran =
            $totalSelisihPembayaran;


        $this->totalKasMasuk =
            $totalKasMasuk;

        $this->totalKasKeluar =
            $totalKasKeluar;

        $this->arusKasBersih =
            $arusKasBersih;
    }


    public function view(): View
    {
        return view(
            'admin.laporan.excel.keuangan',
            [

                'sales' =>
                    $this->sales,

                'returns' =>
                    $this->returns,

                'cashTransactions' =>
                    $this->cashTransactions,


                'tanggalMulai' =>
                    $this->tanggalMulai,

                'tanggalAkhir' =>
                    $this->tanggalAkhir,


                'totalPenjualan' =>
                    $this->totalPenjualan,

                'totalPenjualanBruto' =>
                    $this->totalPenjualanBruto,

                'totalPenjualanBersih' =>
                    $this->totalPenjualanBersih,

                'totalDiskon' =>
                    $this->totalDiskon,

                'totalHpp' =>
                    $this->totalHpp,

                'labaKotor' =>
                    $this->labaKotor,


                'totalRetur' =>
                    $this->totalRetur,

                'totalReturUang' =>
                    $this->totalReturUang,

                'totalTukarBarang' =>
                    $this->totalTukarBarang,

                'totalNilaiPengganti' =>
                    $this->totalNilaiPengganti,

                'totalSelisihPembayaran' =>
                    $this->totalSelisihPembayaran,


                'totalKasMasuk' =>
                    $this->totalKasMasuk,

                'totalKasKeluar' =>
                    $this->totalKasKeluar,

                'arusKasBersih' =>
                    $this->arusKasBersih,

            ]
        );
    }
}