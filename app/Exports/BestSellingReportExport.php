<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BestSellingReportExport implements
    FromCollection,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    protected Collection $products;

    protected string $tanggalMulai;

    protected string $tanggalAkhir;

    protected string $categoryLabel;


    public function __construct(
        Collection $products,
        string $tanggalMulai = '',
        string $tanggalAkhir = '',
        string $categoryLabel = 'Semua Kategori'
    ) {
        $this->products = $products;

        $this->tanggalMulai = $tanggalMulai;

        $this->tanggalAkhir = $tanggalAkhir;

        $this->categoryLabel = $categoryLabel;
    }


    /**
     * Data Excel
     */
    public function collection()
    {
        $rows = collect();


        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        $rows->push([
            'LAPORAN BARANG TERLARIS'
        ]);

        $rows->push([
            'Nayla Bangunan'
        ]);


        /*
        |--------------------------------------------------------------------------
        | INFORMASI FILTER
        |--------------------------------------------------------------------------
        */

        $rows->push([
            'Tanggal Mulai',
            $this->tanggalMulai !== ''
                ? $this->tanggalMulai
                : 'Semua'
        ]);

        $rows->push([
            'Tanggal Akhir',
            $this->tanggalAkhir !== ''
                ? $this->tanggalAkhir
                : 'Semua'
        ]);

        $rows->push([
            'Kategori',
            $this->categoryLabel
        ]);


        $rows->push([
            ''
        ]);


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $rows->push([
            'Total Produk Terjual',
            $this->products->count()
        ]);

        $rows->push([
            'Total Qty Terjual',
            $this->products->sum('total_terjual')
        ]);

        $produkTerlaris = $this->products->first();

        $rows->push([
            'Produk Terlaris',
            $produkTerlaris?->product?->nama_produk ?? '-'
        ]);


        $rows->push([
            ''
        ]);


        /*
        |--------------------------------------------------------------------------
        | HEADER TABEL
        |--------------------------------------------------------------------------
        */

        $rows->push([
            'Peringkat',
            'Nama Produk',
            'SKU',
            'Kategori',
            'Total Terjual',
            'Satuan'
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        foreach ($this->products as $index => $item) {

            $rows->push([
                $index + 1,
                $item->product->nama_produk ?? '-',
                $item->product->sku ?? '-',
                $item->product->category->nama_kategori ?? '-',
                $item->total_terjual,
                $item->product->satuan ?? '-'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | DATA KOSONG
        |--------------------------------------------------------------------------
        */

        if ($this->products->isEmpty()) {

            $rows->push([
                '',
                'Belum ada data penjualan.',
                '',
                '',
                '',
                ''
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | WAKTU CETAK
        |--------------------------------------------------------------------------
        */

        $rows->push([
            ''
        ]);

        $rows->push([
            'Dicetak',
            now()->format('d/m/Y H:i')
        ]);


        return $rows;
    }


    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        $sheet->mergeCells('A1:F1');

        $sheet->mergeCells('A2:F2');


        $sheet->getStyle('A1:F1')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 18,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],

        ]);


        $sheet->getStyle('A2:F2')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 12,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | INFORMASI FILTER
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A3:B5')->applyFromArray([

            'font' => [
                'size' => 10,
            ],

        ]);

        $sheet->getStyle('A3:A5')->applyFromArray([

            'font' => [
                'bold' => true,
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A7:B9')->applyFromArray([

            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => [
                        'rgb' => 'D9D9D9'
                    ],
                ],
            ],

        ]);

        $sheet->getStyle('A7:A9')->applyFromArray([

            'font' => [
                'bold' => true,
            ],

        ]);

        $sheet->getStyle('A7:A9')
            ->getAlignment()
            ->setVertical('center');

        $sheet->getStyle('B7:B9')
            ->getAlignment()
            ->setVertical('center');

        $sheet->getStyle('B7:B8')
            ->getAlignment()
            ->setHorizontal('right');

        $sheet->getStyle('B7:B8')
            ->getNumberFormat()
            ->setFormatCode('#,##0');


        /*
        |--------------------------------------------------------------------------
        | HEADER TABEL
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A11:F11')->applyFromArray([

            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ],
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],

            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => '355CC9'
                ],
            ],

            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => [
                        'rgb' => 'CCCCCC'
                    ],
                ],
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA TABEL
        |--------------------------------------------------------------------------
        */

        $lastRow = 11 + $this->products->count();

        if ($this->products->isEmpty()) {
            $lastRow = 12;
        }


        $sheet->getStyle(
            'A11:F' . $lastRow
        )->applyFromArray([

            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => [
                        'rgb' => 'D9D9D9'
                    ],
                ],
            ],

            'alignment' => [
                'vertical' => 'center',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | ALIGNMENT
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle(
            'A12:A' . $lastRow
        )->getAlignment()
            ->setHorizontal('center');


        $sheet->getStyle(
            'E12:E' . $lastRow
        )->getAlignment()
            ->setHorizontal('right');


        $sheet->getStyle(
            'F12:F' . $lastRow
        )->getAlignment()
            ->setHorizontal('center');


        /*
        |--------------------------------------------------------------------------
        | FORMAT ANGKA
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle(
            'A12:A' . $lastRow
        )->getNumberFormat()
            ->setFormatCode('0');


        $sheet->getStyle(
            'E12:E' . $lastRow
        )->getNumberFormat()
            ->setFormatCode('#,##0');


        /*
        |--------------------------------------------------------------------------
        | TINGGI BARIS
        |--------------------------------------------------------------------------
        */

        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->getRowDimension(2)->setRowHeight(22);

        $sheet->getRowDimension(11)->setRowHeight(25);


        /*
        |--------------------------------------------------------------------------
        | FREEZE HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->freezePane('A12');


        return $sheet;
    }


    /**
     * Lebar Kolom
     */
    public function columnWidths(): array
    {
        return [

            'A' => 24,

            'B' => 30,

            'C' => 22,

            'D' => 20,

            'E' => 18,

            'F' => 14,

        ];
    }


    /**
     * Nama Sheet
     */
    public function title(): string
    {
        return 'Barang Terlaris';
    }
}