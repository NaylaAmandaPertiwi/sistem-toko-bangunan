<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FinancialReportExport implements FromView
{
    protected $sales;
    protected $tanggalMulai;
    protected $tanggalAkhir;
    protected $totalPenjualan;
    protected $totalDiskon;
    protected $totalHpp;
    protected $labaKotor;

    public function __construct(
        $sales,
        $tanggalMulai,
        $tanggalAkhir,
        $totalPenjualan,
        $totalDiskon,
        $totalHpp,
        $labaKotor
    ) {
        $this->sales = $sales;

        $this->tanggalMulai = $tanggalMulai;

        $this->tanggalAkhir = $tanggalAkhir;

        $this->totalPenjualan = $totalPenjualan;

        $this->totalDiskon = $totalDiskon;

        $this->totalHpp = $totalHpp;

        $this->labaKotor = $labaKotor;
    }


    public function view(): View
    {
        return view(
            'admin.laporan.excel.keuangan',
            [
                'sales' => $this->sales,

                'tanggalMulai' =>
                    $this->tanggalMulai,

                'tanggalAkhir' =>
                    $this->tanggalAkhir,

                'totalPenjualan' =>
                    $this->totalPenjualan,

                'totalDiskon' =>
                    $this->totalDiskon,

                'totalHpp' =>
                    $this->totalHpp,

                'labaKotor' =>
                    $this->labaKotor,
            ]
        );
    }
}