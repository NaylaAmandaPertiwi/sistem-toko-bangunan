<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockReportExport implements
    FromCollection,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    protected Collection $products;

    protected string $search;

    protected string $category;

    protected string $statusStok;

    protected string $categoryLabel;


    public function __construct(
        Collection $products,
        string $search = '',
        string $category = '',
        string $statusStok = '',
        string $categoryLabel = 'Semua Kategori'
    ) {
        $this->products = $products;

        $this->search = $search;

        $this->category = $category;

        $this->statusStok = $statusStok;

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
            'NAYLA BANGUNAN'
        ]);

        $rows->push([
            'LAPORAN STOK'
        ]);

        $rows->push([
            'Laporan Persediaan Barang'
        ]);

        $rows->push([
            'Pencarian Produk',
            $this->search !== ''
                ? $this->search
                : 'Semua Produk'
        ]);

        $rows->push([
            'Kategori',
            $this->categoryLabel
        ]);

        $rows->push([
            'Status Stok',
            $this->getStatusLabel()
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
            'No',
            'Nama Produk',
            'SKU',
            'Barcode',
            'Kategori',
            'Stok',
            'Satuan',
            'Stok Minimum',
            'Status'
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA PRODUK
        |--------------------------------------------------------------------------
        */

        foreach ($this->products as $index => $product) {

            $stok = (int) $product->stok;

            if ($stok <= 0) {

                $status = 'Habis';

            } elseif (
                $stok <= $product->stok_minimum
            ) {

                $status = 'Menipis';

            } else {

                $status = 'Aman';

            }

            // Pastikan stok 0 tetap tampil sebagai "0" di Excel
            $stokDisplay = $stok === 0
                ? '0'
                : $stok;


            $rows->push([
                $index + 1,
                $product->nama_produk,
                $product->sku ?? '-',
                $product->barcode ?? '-',
                $product->category->nama_kategori ?? '-',
                $stokDisplay,
                $product->satuan,
                (int) $product->stok_minimum,
                $status
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
                'Tidak ada data stok.',
                '',
                '',
                '',
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
     * Label Status
     */
    protected function getStatusLabel(): string
    {
        return match ($this->statusStok) {

            'aman' => 'Aman',

            'menipis' => 'Menipis',

            'habis' => 'Habis',

            default => 'Semua Status',

        };
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

        $sheet->mergeCells('A1:I1');

        $sheet->mergeCells('A2:I2');

        $sheet->mergeCells('A3:I3');


        $sheet->getStyle('A1:I1')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 18,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],

        ]);


        $sheet->getStyle('A2:I2')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 12,
            ],

            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],

        ]);

        $sheet->getStyle('A3:I3')->applyFromArray([

            'font' => [
                'italic' => true,
                'size' => 10,
                'color' => [
                    'rgb' => '808080'
                ],
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

        $sheet->getStyle('A4:B6')->applyFromArray([

            'font' => [
                'size' => 10,
            ],

        ]);

        $sheet->getStyle('A4:A6')->applyFromArray([

            'font' => [
                'bold' => true,
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | HEADER TABEL
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle('A8:I8')->applyFromArray([

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
        | TABEL DATA
        |--------------------------------------------------------------------------
        */

        $lastRow = 8 + $this->products->count();

        $sheet->getStyle(
            'A8:I' . $lastRow
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
        | ALIGNMENT KOLOM
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle(
            'A9:A' . $lastRow
        )->getAlignment()
            ->setHorizontal('center');

        $sheet->getStyle(
            'F8:F' . $lastRow
        )->getAlignment()
            ->setHorizontal('right');

        $sheet->getStyle(
            'G8:G' . $lastRow
        )->getAlignment()
            ->setHorizontal('center');

        $sheet->getStyle(
            'H8:H' . $lastRow
        )->getAlignment()
            ->setHorizontal('right');

        $sheet->getStyle(
            'I8:I' . $lastRow
        )->getAlignment()
            ->setHorizontal('center');

       /*
        |--------------------------------------------------------------------------
        | FORMAT ANGKA
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle(
            'F9:F' . $lastRow
        )->getNumberFormat()
            ->setFormatCode('#,##0;-#,##0;0');

        $sheet->getStyle(
            'H9:H' . $lastRow
        )->getNumberFormat()
            ->setFormatCode('#,##0;-#,##0;0');


        /*
        |--------------------------------------------------------------------------
        | TINGGI BARIS
        |--------------------------------------------------------------------------
        */

        $sheet->getRowDimension(1)->setRowHeight(28);

        $sheet->getRowDimension(2)->setRowHeight(22);

        $sheet->getRowDimension(3)->setRowHeight(20);

        $sheet->getRowDimension(8)->setRowHeight(25);


        /*
        |--------------------------------------------------------------------------
        | FREEZE HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->freezePane('A9');


        return $sheet;
    }


    /**
     * Lebar Kolom
     */
    public function columnWidths(): array
    {
        return [

            'A' => 18,

            'B' => 28,

            'C' => 18,

            'D' => 18,

            'E' => 18,

            'F' => 14,

            'G' => 12,

            'H' => 17,

            'I' => 15,

        ];
    }


    /**
     * Nama Sheet
     */
    public function title(): string
    {
        return 'Laporan Stok';
    }
}