<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Penjualan - Nayla Bangunan</title>

    <style>

        @page {
            margin: 35px 35px 45px 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 0;
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            width: 100%;
            text-align: center;
            margin-bottom: 15px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #1684e0;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            color: #222;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .report-subtitle {
            font-size: 9px;
            color: #777;
        }

        .header-line {
            border-bottom: 2px solid #1684e0;
            margin-top: 12px;
        }


        /* =====================================================
           INFORMASI LAPORAN
        ===================================================== */

        .information-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 7px;
            color: #222;
        }

        .information-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .information-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .information-label {
            width: 105px;
            font-weight: bold;
            color: #555;
        }

        .information-separator {
            width: 10px;
        }


        /* =====================================================
           SUMMARY
        ===================================================== */

        .summary {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-left: -8px;
            margin-bottom: 18px;
        }

        .summary td {
            width: 50%;
            border: 1px solid #dfe4ec;
            padding: 11px;
            background: #f8f9fc;
        }

        .summary-label {
            font-size: 9px;
            color: #777;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .summary-value {
            font-size: 15px;
            font-weight: bold;
            color: #222;
        }


        /* =====================================================
           JUDUL DETAIL
        ===================================================== */

        .section-title {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0 12px;
        }

        .section-title td {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #333;
            padding: 7px 0;
            border-top: 1px solid #d9e1ea;
            border-bottom: 1px solid #d9e1ea;
        }


        /* =====================================================
           TABEL
        ===================================================== */

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .report-table th {
            background: #1684e0;
            color: white;
            border: 1px solid #1684e0;
            padding: 7px 5px;
            text-align: center;
            font-size: 8.5px;
            font-weight: bold;
        }

        .report-table td {
            border: 1px solid #d9dee7;
            padding: 6px 5px;
            font-size: 8.5px;
            vertical-align: middle;
        }

        .report-table tbody tr:nth-child(even) {
            background: #f8f9fc;
        }


        /* =====================================================
           LEBAR KOLOM
        ===================================================== */

        .col-no {
            width: 5%;
            text-align: center;
        }

        .col-kode {
            width: 20%;
        }

        .col-tanggal {
            width: 12%;
            text-align: center;
        }

        .col-kasir {
            width: 11%;
            text-align: center;
        }

        .col-subtotal {
            width: 17%;
            text-align: right;
        }

        .col-diskon {
            width: 15%;
            text-align: right;
        }

        .col-total {
            width: 20%;
            text-align: right;
            font-weight: bold;
        }


        /* =====================================================
           TOTAL AKHIR
        ===================================================== */

        .grand-total {
            width: 100%;
            margin-top: 15px;
        }

        .grand-total-table {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .grand-total-table td {
            border: 1px solid #d9dee7;
            padding: 7px 9px;
        }

        .grand-total-label {
            background: #f4f6fb;
            font-weight: bold;
        }

        .grand-total-value {
            text-align: right;
            font-size: 11px;
            font-weight: bold;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            position: fixed;
            bottom: -25px;
            left: 0;
            right: 0;

            border-top: 1px solid #d9dee7;

            padding-top: 7px;

            font-size: 8px;
            color: #777;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

    </style>

</head>


<body>


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="header">

        <div class="company-name">
            NAYLA BANGUNAN
        </div>

        <div class="report-title">
            Laporan Penjualan
        </div>

        <div class="report-subtitle">
            Laporan Transaksi Penjualan
        </div>

        <div class="header-line"></div>

    </div>


    {{-- =====================================================
         INFORMASI LAPORAN
    ====================================================== --}}

    <table class="section-title">
        <tr>
            <td>
                Informasi Laporan
            </td>
        </tr>
    </table>

    <table class="information-table">

        <tr>

            <td class="information-label">
                Periode
            </td>

            <td class="information-separator">
                :
            </td>

            <td>
                Periode: {{ $periodLabel }}
            </td>

        </tr>


        <tr>

            <td class="information-label">
                Kasir
            </td>

            <td class="information-separator">
                :
            </td>

            <td>

                @if(request('kasir'))

                    {{ optional(
                        \App\Models\User::find(request('kasir'))
                    )->name ?? '-' }}

                @else

                    Semua Kasir

                @endif

            </td>

        </tr>


        @if(request('kode'))

            <tr>

                <td class="information-label">
                    Kode Penjualan
                </td>

                <td class="information-separator">
                    :
                </td>

                <td>
                    {{ request('kode') }}
                </td>

            </tr>

        @endif


        <tr>

            <td class="information-label">
                Tanggal Cetak
            </td>

            <td class="information-separator">
                :
            </td>

            <td>
                {{ now()->format('d/m/Y H:i') }}
            </td>

        </tr>

    </table>


    {{-- =====================================================
         RINGKASAN
    ====================================================== --}}

    <table class="summary">

        <tr>

            <td>

                <div class="summary-label">
                    Total Transaksi
                </div>

                <div class="summary-value">
                    {{ $totalTransaksi }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Total Penjualan
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                </div>

            </td>

        </tr>

    </table>


    {{-- =====================================================
         DETAIL TRANSAKSI
    ====================================================== --}}

    <table class="section-title">
        <tr>
            <td>
                Detail Transaksi Penjualan
            </td>
        </tr>
    </table>


    <table class="report-table">

        <thead>

            <tr>

                <th class="col-no">
                    No
                </th>

                <th class="col-kode">
                    Kode Penjualan
                </th>

                <th class="col-tanggal">
                    Tanggal
                </th>

                <th class="col-kasir">
                    Kasir
                </th>

                <th class="col-subtotal">
                    Subtotal
                </th>

                <th class="col-diskon">
                    Diskon
                </th>

                <th class="col-total">
                    Total Bayar
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($sales as $index => $sale)

                <tr>

                    <td class="col-no">
                        {{ $index + 1 }}
                    </td>

                    <td class="col-kode">
                        {{ $sale->kode_penjualan }}
                    </td>

                    <td class="col-tanggal">
                        {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
                    </td>

                    <td class="col-kasir">
                        {{ $sale->user->name ?? '-' }}
                    </td>

                    <td class="col-subtotal">
                        Rp {{ number_format($sale->subtotal, 0, ',', '.') }}
                    </td>

                    <td class="col-diskon">
                        Rp {{ number_format($sale->diskon, 0, ',', '.') }}
                    </td>

                    <td class="col-total">
                        Rp {{ number_format($sale->total_bayar, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="text-center"
                        style="text-align:center; padding:15px;"
                    >
                        Tidak ada data penjualan.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =====================================================
         TOTAL AKHIR
    ====================================================== --}}

    <div class="grand-total">

        <table class="grand-total-table">

            <tr>

                <td class="grand-total-label">
                    Total Penjualan
                </td>

                <td class="grand-total-value">
                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                </td>

            </tr>

        </table>

    </div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="footer">

        <div class="footer-left">
            Nayla Bangunan — Laporan Penjualan
        </div>

        <div class="footer-right">
            Dicetak: {{ now()->format('d/m/Y H:i') }}
        </div>

    </div>


</body>

</html>