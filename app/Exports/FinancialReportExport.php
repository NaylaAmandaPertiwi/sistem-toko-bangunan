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
    protected $uangPenjualan;
    protected $totalHpp;
    protected $labaKotor;
    protected $totalBebanOperasional;
    protected $labaBersih;

    protected $totalReturUang;
    protected $jumlahTukarBarang;
    protected $nilaiBarangDikembalikan;
    protected $nilaiBarangPengganti;
    protected $selisihTukarBarang;

    protected $kasMasukDariTukar;
    protected $kasKeluarDariReturUang;
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
        $uangPenjualan,
        $totalHpp,
        $labaKotor,
        $totalBebanOperasional,
        $labaBersih,

        $totalReturUang,
        $jumlahTukarBarang,
        $nilaiBarangDikembalikan,
        $nilaiBarangPengganti,
        $selisihTukarBarang,

        $kasMasukDariTukar,
        $kasKeluarDariReturUang,
        $arusKasBersih
    ) {
        $this->sales = $sales;
        $this->returns = $returns;
        $this->cashTransactions = $cashTransactions;

        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalAkhir = $tanggalAkhir;

        $this->totalPenjualan = $totalPenjualan;
        $this->totalPenjualanBruto = $totalPenjualanBruto;
        $this->totalPenjualanBersih = $totalPenjualanBersih;
        $this->totalDiskon = $totalDiskon;
        $this->uangPenjualan = $uangPenjualan;
        $this->totalHpp = $totalHpp;
        $this->labaKotor = $labaKotor;
        $this->totalBebanOperasional = $totalBebanOperasional;
        $this->labaBersih = $labaBersih;

        $this->totalReturUang = $totalReturUang;
        $this->jumlahTukarBarang = $jumlahTukarBarang;
        $this->nilaiBarangDikembalikan = $nilaiBarangDikembalikan;
        $this->nilaiBarangPengganti = $nilaiBarangPengganti;
        $this->selisihTukarBarang = $selisihTukarBarang;

        $this->kasMasukDariTukar = $kasMasukDariTukar;
        $this->kasKeluarDariReturUang = $kasKeluarDariReturUang;
        $this->arusKasBersih = $arusKasBersih;
    }


    public function view(): View
    {
        return view(
            'admin.laporan.excel.keuangan',
            [
                'sales' => $this->sales,
                'returns' => $this->returns,
                'cashTransactions' => $this->cashTransactions,

                'tanggalMulai' => $this->tanggalMulai,
                'tanggalAkhir' => $this->tanggalAkhir,

                'totalPenjualan' => $this->totalPenjualan,
                'totalPenjualanBruto' => $this->totalPenjualanBruto,
                'totalPenjualanBersih' => $this->totalPenjualanBersih,
                'totalDiskon' => $this->totalDiskon,
                'uangPenjualan' => $this->uangPenjualan,
                'totalHpp' => $this->totalHpp,
                'labaKotor' => $this->labaKotor,
                'totalBebanOperasional' => $this->totalBebanOperasional,
                'labaBersih' => $this->labaBersih,

                'totalReturUang' => $this->totalReturUang,
                'jumlahTukarBarang' => $this->jumlahTukarBarang,
                'nilaiBarangDikembalikan' => $this->nilaiBarangDikembalikan,
                'nilaiBarangPengganti' => $this->nilaiBarangPengganti,
                'selisihTukarBarang' => $this->selisihTukarBarang,

                'kasMasukDariTukar' => $this->kasMasukDariTukar,
                'kasKeluarDariReturUang' => $this->kasKeluarDariReturUang,
                'arusKasBersih' => $this->arusKasBersih,
            ]
        );
    }
}