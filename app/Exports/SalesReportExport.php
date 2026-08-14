<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements
    FromArray,
    WithStyles,
    WithColumnWidths,
    WithEvents,
    WithTitle
{
    protected Collection $sales;
    protected string $filter;
    protected string $periodLabel;
    protected ?string $tanggal;
    protected $kasir;
    protected ?string $kode;

    public function __construct(
        Collection $sales,
        string $filter = 'all',
        string $periodLabel = 'Semua Periode',
        ?string $tanggal = null,
        $kasir = null,
        ?string $kode = null
    ) {
        $this->sales = $sales;
        $this->filter = $filter;
        $this->periodLabel = $periodLabel;
        $this->tanggal = $tanggal;
        $this->kasir = $kasir;
        $this->kode = $kode;
    }

    /**
     * Data worksheet.
     */
    public function array(): array
    {
        $rows = [];

        /*
        |--------------------------------------------------------------------------
        | HEADER LAPORAN
        |--------------------------------------------------------------------------
        */

        $rows[] = [
            'NAYLA BANGUNAN'
        ];

        $rows[] = [
            'LAPORAN PENJUALAN'
        ];

        $rows[] = [
            'Laporan Transaksi Penjualan'
        ];

        /*
        |--------------------------------------------------------------------------
        | INFORMASI LAPORAN
        |--------------------------------------------------------------------------
        */

        $rows[] = [
            'Periode',
            $this->getPeriodLabel()
        ];

        $rows[] = [
            'Kasir',
            $this->getCashierName()
        ];

        $rows[] = [
            'Kode Penjualan',
            $this->kode ?: 'Semua'
        ];

        $rows[] = [
            'Tanggal Cetak',
            now()->format('d/m/Y H:i')
        ];

        /*
        |--------------------------------------------------------------------------
        | HEADER TABEL
        |--------------------------------------------------------------------------
        */

        $rows[] = [
            'No',
            'Kode Penjualan',
            'Tanggal',
            'Kasir',
            'Subtotal',
            'Diskon',
            'Total Bayar'
        ];

        /*
        |--------------------------------------------------------------------------
        | DATA PENJUALAN
        |--------------------------------------------------------------------------
        */

        foreach ($this->sales as $index => $sale) {

            $rows[] = [
                $index + 1,
                $sale->kode_penjualan,
                \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y'),
                $sale->user->name ?? '-',
                (float) $sale->subtotal,
                (float) $sale->diskon,
                (float) $sale->total_bayar,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $rows[] = [
            'Total Transaksi',
            '',
            '',
            '',
            '',
            $this->sales->count(),
            ''
        ];

        $rows[] = [
            'Total Penjualan',
            '',
            '',
            '',
            '',
            (float) $this->sales->sum('total_bayar'),
            ''
        ];

        return $rows;
    }

    /**
     * Label periode.
     */
    protected function getPeriodLabel(): string
    {
        return $this->periodLabel;
    }

    /**
     * Nama kasir.
     */
    protected function getCashierName(): string
    {
        if (!$this->kasir) {
            return 'Semua Kasir';
        }

        $cashier = User::find($this->kasir);

        return $cashier
            ? $cashier->name
            : 'Semua Kasir';
    }

    /**
     * Styling dasar.
     */
    public function styles(Worksheet $sheet)
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | JUDUL
            |--------------------------------------------------------------------------
            */

            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 18,
                    'color' => [
                        'rgb' => '1684E0',
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            2 => [
                'font' => [
                    'bold' => true,
                    'size' => 15,
                    'color' => [
                        'rgb' => '222222',
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            3 => [
                'font' => [
                    'italic' => true,
                    'size' => 10,
                    'color' => [
                        'rgb' => '777777',
                    ],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | INFORMASI
            |--------------------------------------------------------------------------
            */

            4 => [
                'font' => [
                    'bold' => true,
                ],
            ],

            5 => [
                'font' => [
                    'bold' => true,
                ],
            ],

            6 => [
                'font' => [
                    'bold' => true,
                ],
            ],

            7 => [
                'font' => [
                    'bold' => true,
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | HEADER TABEL
            |--------------------------------------------------------------------------
            */

            8 => [
                'font' => [
                    'bold' => true,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],

                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => '1684E0',
                    ],
                ],

                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Lebar kolom.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 16,
            'B' => 24,
            'C' => 15,
            'D' => 18,
            'E' => 20,
            'F' => 18,
            'G' => 22,
        ];
    }

    /**
     * Nama worksheet.
     */
    public function title(): string
    {
        return 'Laporan Penjualan';
    }

    /**
     * Event setelah worksheet dibuat.
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | POSISI BARIS
                |--------------------------------------------------------------------------
                */

                $headerRow = 8;

                $firstDataRow = 9;

                $lastDataRow = $firstDataRow + $this->sales->count() - 1;

                /*
                |--------------------------------------------------------------------------
                | Jika tidak ada data
                |--------------------------------------------------------------------------
                */

                if ($this->sales->count() === 0) {
                    $lastDataRow = $headerRow;
                }

                /*
                |--------------------------------------------------------------------------
                | POSISI RINGKASAN
                |--------------------------------------------------------------------------
                */

                $summaryStartRow = $lastDataRow + 1;

                /*
                |--------------------------------------------------------------------------
                | MERGE JUDUL
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');

                /*
                |--------------------------------------------------------------------------
                | MERGE INFORMASI
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('B4:G4');
                $sheet->mergeCells('B5:G5');
                $sheet->mergeCells('B6:G6');
                $sheet->mergeCells('B7:G7');

                /*
                |--------------------------------------------------------------------------
                | GARIS BAWAH HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A3:G3')
                    ->getBorders()
                    ->getBottom()
                    ->setBorderStyle(
                        Border::BORDER_MEDIUM
                    );

                $sheet->getStyle('A3:G3')
                    ->getBorders()
                    ->getBottom()
                    ->getColor()
                    ->setRGB('1684E0');

                /*
                |--------------------------------------------------------------------------
                | INFORMASI LAPORAN
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A4:G7')->applyFromArray([

                    'borders' => [
                        'bottom' => [
                            'borderStyle' => Border::BORDER_HAIR,
                            'color' => [
                                'rgb' => 'DDDDDD',
                            ],
                        ],
                    ],

                ]);

                $sheet->getStyle('A4:A7')
                    ->getFont()
                    ->setBold(true);

                /*
                |--------------------------------------------------------------------------
                | HEADER TABEL
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    "A{$headerRow}:G{$headerRow}"
                )->applyFromArray([

                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '1684E0',
                        ],
                    ],

                    'font' => [
                        'bold' => true,
                        'color' => [
                            'rgb' => 'FFFFFF',
                        ],
                    ],

                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],

                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => 'D9E2F3',
                            ],
                        ],
                    ],

                ]);

                /*
                |--------------------------------------------------------------------------
                | DATA TABEL
                |--------------------------------------------------------------------------
                */

                if ($this->sales->count() > 0) {

                    $sheet->getStyle(
                        "A{$firstDataRow}:G{$lastDataRow}"
                    )->applyFromArray([

                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => [
                                    'rgb' => 'D9E2F3',
                                ],
                            ],
                        ],

                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],

                    ]);

                    /*
                    |--------------------------------------------------------------
                    | Nomor
                    |--------------------------------------------------------------
                    */

                    $sheet->getStyle(
                        "A{$firstDataRow}:A{$lastDataRow}"
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );

                    /*
                    |--------------------------------------------------------------
                    | Tanggal
                    |--------------------------------------------------------------
                    */

                    $sheet->getStyle(
                        "C{$firstDataRow}:C{$lastDataRow}"
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );

                    /*
                    |--------------------------------------------------------------
                    | Format Rupiah
                    |--------------------------------------------------------------
                    */

                    $sheet->getStyle(
                        "E{$firstDataRow}:G{$lastDataRow}"
                    )->getNumberFormat()
                        ->setFormatCode(
                            '"Rp " #,##0'
                        );

                    $sheet->getStyle(
                        "E{$firstDataRow}:G{$lastDataRow}"
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_RIGHT
                        );

                    /*
                    |--------------------------------------------------------------
                    | Total Bayar Tebal
                    |--------------------------------------------------------------
                    */

                    $sheet->getStyle(
                        "G{$firstDataRow}:G{$lastDataRow}"
                    )->getFont()
                        ->setBold(true);
                }

                /*
                |--------------------------------------------------------------------------
                | RINGKASAN
                |--------------------------------------------------------------------------
                */

                $totalTransaksiRow = $summaryStartRow;

                $totalPenjualanRow = $summaryStartRow + 1;

                /*
                |--------------------------------------------------------------
                | Merge label
                |--------------------------------------------------------------
                */

                $sheet->mergeCells(
                    "A{$totalTransaksiRow}:E{$totalTransaksiRow}"
                );

                $sheet->mergeCells(
                    "A{$totalPenjualanRow}:E{$totalPenjualanRow}"
                );

                /*
                |--------------------------------------------------------------
                | Border
                |--------------------------------------------------------------
                */

                $sheet->getStyle(
                    "A{$totalTransaksiRow}:G{$totalPenjualanRow}"
                )->applyFromArray([

                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => 'D9E2F3',
                            ],
                        ],
                    ],

                ]);

                /*
                |--------------------------------------------------------------
                | Font
                |--------------------------------------------------------------
                */

                $sheet->getStyle(
                    "A{$totalTransaksiRow}:G{$totalPenjualanRow}"
                )->getFont()
                    ->setBold(true);

                /*
                |--------------------------------------------------------------
                | Posisi label
                |--------------------------------------------------------------
                */

               $sheet->getStyle(
                    "A{$totalTransaksiRow}:E{$totalPenjualanRow}"
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_LEFT
                    );

                /*
                |--------------------------------------------------------------
                | Nilai Total Transaksi
                |--------------------------------------------------------------
                */

                $sheet->getStyle(
                    "F{$totalTransaksiRow}"
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_RIGHT
                    );

                /*
                |--------------------------------------------------------------
                | Nilai Total Penjualan
                |--------------------------------------------------------------
                */

                $sheet->getStyle(
                    "F{$totalPenjualanRow}"
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_RIGHT
                    );

                $sheet->getStyle(
                    "F{$totalPenjualanRow}"
                )->getNumberFormat()
                    ->setFormatCode(
                        '"Rp " #,##0'
                    );

                /*
                |--------------------------------------------------------------------------
                | TINGGI BARIS
                |--------------------------------------------------------------------------
                */

                $sheet->getRowDimension(1)
                    ->setRowHeight(28);

                $sheet->getRowDimension(2)
                    ->setRowHeight(24);

                $sheet->getRowDimension(3)
                    ->setRowHeight(20);

                $sheet->getRowDimension(8)
                    ->setRowHeight(25);

                /*
                |--------------------------------------------------------------------------
                | FREEZE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A9');

                /*
                |--------------------------------------------------------------------------
                | FILTER EXCEL
                |--------------------------------------------------------------------------
                */

                if ($this->sales->count() > 0) {

                    $sheet->setAutoFilter(
                        "A8:G{$lastDataRow}"
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | PAGE SETUP
                |--------------------------------------------------------------------------
                */

                $sheet->getPageSetup()
                    ->setOrientation(
                        PageSetup::ORIENTATION_LANDSCAPE
                    );

                $sheet->getPageSetup()
                    ->setPaperSize(
                        PageSetup::PAPERSIZE_A4
                    );

                $sheet->getPageSetup()
                    ->setFitToWidth(1);

                $sheet->getPageSetup()
                    ->setFitToHeight(0);

                /*
                |--------------------------------------------------------------------------
                | MARGIN CETAK
                |--------------------------------------------------------------------------
                */

                $sheet->getPageMargins()
                    ->setTop(0.5)
                    ->setRight(0.4)
                    ->setLeft(0.4)
                    ->setBottom(0.5);

                /*
                |--------------------------------------------------------------------------
                | AREA CETAK
                |--------------------------------------------------------------------------
                */

                $sheet->getPageSetup()
                    ->setPrintArea(
                        "A1:G{$totalPenjualanRow}"
                    );

                /*
                |--------------------------------------------------------------------------
                | HEADER CETAK
                |--------------------------------------------------------------------------
                */

                $sheet->getHeaderFooter()
                    ->setOddHeader(
                        '&CNAYLA BANGUNAN'
                    );

                /*
                |--------------------------------------------------------------------------
                | FOOTER CETAK
                |--------------------------------------------------------------------------
                */

                $sheet->getHeaderFooter()
                    ->setOddFooter(
                        '&LDicetak: ' .
                        now()->format('d/m/Y H:i') .
                        '&RHalaman &P dari &N'
                    );
            },
        ];
    }
}