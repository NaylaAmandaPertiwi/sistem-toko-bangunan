<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Stok</title>

    <style>

        @page {
            margin: 35px 35px 45px 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 22px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .header .company {
            margin-top: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        .header .period {
            margin-top: 5px;
            font-size: 10px;
            color: #666;
        }


        /* =========================
           RINGKASAN
        ========================= */

        .summary {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: separate;
            border-spacing: 8px;
        }

        .summary td {
            width: 25%;
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        .summary-label {
            font-size: 9px;
            color: #666;
        }

        .summary-value {
            margin-top: 5px;
            font-size: 14px;
            font-weight: bold;
        }


        /* =========================
           FILTER INFORMASI
        ========================= */

        .filter-info {
            width: 100%;
            margin-bottom: 18px;
            border-collapse: collapse;
        }

        .filter-info td {
            padding: 5px 7px;
            border-bottom: 1px solid #eee;
        }

        .filter-label {
            width: 25%;
            font-weight: bold;
        }


        /* =========================
           TABEL
        ========================= */

        table.report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table thead {
            display: table-header-group;
        }

        .report-table th {
            background: #355cc9;
            color: white;
            border: 1px solid #2d4fae;
            padding: 8px 6px;
            text-align: center;
            font-size: 9px;
        }

        .report-table td {
            border: 1px solid #ccc;
            padding: 7px 6px;
            font-size: 9px;
        }

        .report-table tr {
            page-break-inside: avoid;
        }


        /* =========================
           ALIGNMENT
        ========================= */

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }


        /* =========================
           STATUS
        ========================= */

        .status {
            font-weight: bold;
            text-align: center;
        }

        .status-aman {
            color: #198754;
        }

        .status-menipis {
            color: #d97706;
        }

        .status-habis {
            color: #dc3545;
        }


        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 8px;
            color: #777;
        }

    </style>

</head>


<body>


    {{-- HEADER --}}

    <div class="header">

        <h1>
            LAPORAN STOK
        </h1>

        <div class="company">
            Nayla Bangunan
        </div>

        <div class="period">
            Dicetak {{ now()->format('d/m/Y H:i') }}
        </div>

    </div>


    {{-- RINGKASAN --}}

    <table class="summary">

        <tr>

            <td>

                <div class="summary-label">
                    Total Produk
                </div>

                <div class="summary-value">
                    {{ $totalProduk }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Total Stok
                </div>

                <div class="summary-value">
                    {{ number_format($totalStok, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Stok Menipis
                </div>

                <div class="summary-value">
                    {{ $stokMenipis }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Stok Habis
                </div>

                <div class="summary-value">
                    {{ $stokHabis }}
                </div>

            </td>

        </tr>

    </table>


    {{-- INFORMASI FILTER --}}

    <table class="filter-info">

        <tr>

            <td class="filter-label">
                Pencarian Produk
            </td>

            <td>
                {{ $search !== '' ? $search : 'Semua Produk' }}
            </td>

        </tr>


        <tr>

            <td class="filter-label">
                Kategori
            </td>

            <td>

                @if($category !== '')

                    {{ optional(
                        \App\Models\Category::find($category)
                    )->nama_kategori ?? '-' }}

                @else

                    Semua Kategori

                @endif

            </td>

        </tr>


        <tr>

            <td class="filter-label">
                Status Stok
            </td>

            <td>

                @switch($statusStok)

                    @case('aman')
                        Aman
                        @break

                    @case('menipis')
                        Menipis
                        @break

                    @case('habis')
                        Habis
                        @break

                    @default
                        Semua Status

                @endswitch

            </td>

        </tr>

    </table>


    {{-- TABEL STOK --}}

    <table class="report-table">

        <thead>

            <tr>

                <th>No</th>

                <th>Nama Produk</th>

                <th>SKU</th>

                <th>Barcode</th>

                <th>Kategori</th>

                <th>Stok</th>

                <th>Satuan</th>

                <th>Stok Minimum</th>

                <th>Status</th>

            </tr>

        </thead>


        <tbody>

            @forelse($products as $index => $product)

                @php

                    if ($product->stok <= 0) {

                        $status = 'Habis';
                        $statusClass = 'status-habis';

                    } elseif (
                        $product->stok <= $product->stok_minimum
                    ) {

                        $status = 'Menipis';
                        $statusClass = 'status-menipis';

                    } else {

                        $status = 'Aman';
                        $statusClass = 'status-aman';

                    }

                @endphp


                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $product->nama_produk }}
                    </td>

                    <td>
                        {{ $product->sku ?? '-' }}
                    </td>

                    <td>
                        {{ $product->barcode ?? '-' }}
                    </td>

                    <td>
                        {{ $product->category->nama_kategori ?? '-' }}
                    </td>

                    <td class="text-right">
                        {{ number_format($product->stok, 0, ',', '.') }}
                    </td>

                    <td class="text-center">
                        {{ $product->satuan }}
                    </td>

                    <td class="text-right">
                        {{ number_format($product->stok_minimum, 0, ',', '.') }}
                    </td>

                    <td class="status {{ $statusClass }}">
                        {{ $status }}
                    </td>

                </tr>


            @empty

                <tr>

                    <td
                        colspan="9"
                        class="text-center"
                    >
                        Tidak ada data stok.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        Dicetak secara otomatis oleh sistem Nayla Bangunan

    </div>


</body>

</html>