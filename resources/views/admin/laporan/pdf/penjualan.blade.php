<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Penjualan</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #555;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            width: 50%;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .summary-label {
            font-size: 10px;
            color: #777;
        }

        .summary-value {
            margin-top: 5px;
            font-size: 16px;
            font-weight: bold;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th {
            background: #f1f3f7;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }

        .report-table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #777;
        }

    </style>

</head>

<body>

    {{-- HEADER --}}

    <div class="header">

        <h1>Laporan Penjualan</h1>

        <p>
            Nayla Bangunan
        </p>

        @if($filter !== 'all')

            <p>
                Periode:
                {{ ucfirst($filter) }}
            </p>

        @endif

    </div>


    {{-- RINGKASAN --}}

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


    {{-- TABEL PENJUALAN --}}

    <table class="report-table">

        <thead>

            <tr>

                <th class="text-center">
                    No
                </th>

                <th>
                    Kode Penjualan
                </th>

                <th>
                    Tanggal
                </th>

                <th>
                    Kasir
                </th>

                <th>
                    Subtotal
                </th>

                <th>
                    Diskon
                </th>

                <th>
                    Total Bayar
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($sales as $index => $sale)

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $sale->kode_penjualan }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $sale->user->name ?? '-' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($sale->subtotal, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($sale->diskon, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        <strong>
                            Rp {{ number_format($sale->total_bayar, 0, ',', '.') }}
                        </strong>
                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="7"
                        class="text-center"
                    >
                        Tidak ada data penjualan.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- FOOTER --}}

    <div class="footer">

        Dicetak pada:
        {{ now()->format('d/m/Y H:i') }}

    </div>

</body>

</html>