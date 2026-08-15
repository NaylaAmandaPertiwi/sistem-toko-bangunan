<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Keuangan</title>

    <style>

        /*
        |--------------------------------------------------------------------------
        | PAGE
        |--------------------------------------------------------------------------
        */

        @page {
            margin: 30px 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;

            font-size: 10px;

            color: #222;

            margin: 0;
        }


        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .header {
            text-align: center;

            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;

            font-size: 18px;

            font-weight: bold;
        }

        .header h2 {
            margin: 5px 0 0;

            font-size: 12px;

            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0;

            font-size: 9px;

            color: #666;
        }


        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        .periode {
            width: 100%;

            margin-bottom: 15px;

            border-collapse: collapse;
        }

        .periode td {
            padding: 5px 0;

            border-bottom: 1px solid #ddd;
        }

        .periode .label {
            width: 120px;

            font-weight: bold;
        }


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        .summary-table {
            width: 100%;

            border-collapse: collapse;

            margin-bottom: 20px;
        }

        .summary-table td {
            width: 25%;

            border: 1px solid #ddd;

            padding: 10px;
        }

        .summary-label {
            font-size: 8px;

            color: #666;

            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 12px;

            font-weight: bold;
        }

        .profit {
            color: #16884a;
        }


        /*
        |--------------------------------------------------------------------------
        | TABEL PENJUALAN
        |--------------------------------------------------------------------------
        */

        .report-table {
            width: 100%;

            border-collapse: collapse;

            margin-top: 10px;
        }

        .report-table th {
            background: #355cc9;

            color: white;

            border: 1px solid #355cc9;

            padding: 7px;

            font-size: 9px;

            text-align: center;

            font-weight: bold;
        }

        .report-table td {
            border: 1px solid #ddd;

            padding: 6px;

            font-size: 9px;
        }


        /*
        |--------------------------------------------------------------------------
        | ALIGNMENT
        |--------------------------------------------------------------------------
        */

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .footer {
            margin-top: 20px;

            text-align: right;

            font-size: 8px;

            color: #777;
        }

    </style>

</head>


<body>


    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="header">

        <h1>
            LAPORAN KEUANGAN
        </h1>

        <h2>
            Nayla Bangunan
        </h2>

        <p>
            Laporan transaksi penjualan dan laba kotor
        </p>

    </div>


    {{-- =========================================================
         PERIODE
    ========================================================== --}}

    <table class="periode">

        <tr>

            <td class="label">
                Tanggal Mulai
            </td>

            <td>
                {{ $tanggalMulai ?: 'Semua' }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Tanggal Akhir
            </td>

            <td>
                {{ $tanggalAkhir ?: 'Semua' }}
            </td>

        </tr>

    </table>


    {{-- =========================================================
         RINGKASAN
    ========================================================== --}}

    <table class="summary-table">

        <tr>

            <td>

                <div class="summary-label">
                    Total Penjualan
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Total Diskon
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalDiskon, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Total HPP
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalHpp, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Laba Kotor
                </div>

                <div class="summary-value profit">
                    Rp {{ number_format($labaKotor, 0, ',', '.') }}
                </div>

            </td>

        </tr>

    </table>


    {{-- =========================================================
         TABEL TRANSAKSI
    ========================================================== --}}

    <table class="report-table">

        <thead>

            <tr>

                <th style="width: 35px;">
                    No
                </th>

                <th style="width: 75px;">
                    Tanggal
                </th>

                <th>
                    Kode Penjualan
                </th>

                <th>
                    Kasir
                </th>

                <th>
                    Penjualan
                </th>

                <th>
                    Diskon
                </th>

                <th>
                    HPP
                </th>

                <th>
                    Laba Kotor
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($sales as $index => $sale)

                @php

                    $hpp = 0;

                    foreach ($sale->saleDetails as $detail) {

                        $hargaBeli =
                            $detail->product->harga_beli ?? 0;

                        $hpp +=
                            $detail->qty * $hargaBeli;

                    }

                    $laba =
                        $sale->total_bayar - $hpp;

                @endphp


                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>


                    <td>
                        {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
                    </td>


                    <td>
                        {{ $sale->kode_penjualan }}
                    </td>


                    <td>
                        {{ $sale->user->name ?? '-' }}
                    </td>


                    <td class="text-right">
                        Rp {{ number_format($sale->total_bayar, 0, ',', '.') }}
                    </td>


                    <td class="text-right">
                        Rp {{ number_format($sale->diskon, 0, ',', '.') }}
                    </td>


                    <td class="text-right">
                        Rp {{ number_format($hpp, 0, ',', '.') }}
                    </td>


                    <td class="text-right">
                        Rp {{ number_format($laba, 0, ',', '.') }}
                    </td>

                </tr>


            @empty

                <tr>

                    <td
                        colspan="8"
                        class="text-center"
                    >
                        Belum ada data penjualan.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <div class="footer">

        Dicetak pada
        {{ now()->format('d/m/Y H:i') }}

    </div>


</body>

</html>