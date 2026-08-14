<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>Laporan Barang Terlaris</title>

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

        .header h2 {
            margin: 5px 0;
            font-size: 14px;
        }

        .header p {
            margin: 3px 0;
            color: #666;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            width: 33.33%;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .summary-label {
            color: #666;
            font-size: 9px;
        }

        .summary-value {
            margin-top: 5px;
            font-size: 15px;
            font-weight: bold;
        }

        .filter {
            margin-bottom: 15px;
        }

        .filter table {
            width: 100%;
        }

        .filter td {
            padding: 4px 0;
        }

        .filter-label {
            width: 120px;
            font-weight: bold;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th {
            background: #355cc9;
            color: white;
            padding: 7px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .report-table td {
            padding: 7px;
            border: 1px solid #ddd;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 9px;
            color: #777;
        }

    </style>

</head>

<body>

    <div class="header">

        <h1>LAPORAN BARANG TERLARIS</h1>

        <h2>Nayla Bangunan</h2>

        <p>
            Laporan berdasarkan jumlah penjualan
        </p>

    </div>


    <table class="summary">

        <tr>

            <td>

                <div class="summary-label">
                    Total Produk Terjual
                </div>

                <div class="summary-value">
                    {{ number_format($totalProduk, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Total Qty Terjual
                </div>

                <div class="summary-value">
                    {{ number_format($totalQty, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Produk Terlaris
                </div>

                <div class="summary-value">
                    {{ $produkTerlaris?->product?->nama_produk ?? '-' }}
                </div>

            </td>

        </tr>

    </table>


    <div class="filter">

        <table>

            <tr>

                <td class="filter-label">
                    Tanggal Mulai
                </td>

                <td>
                    {{ $tanggalMulai ?: 'Semua' }}
                </td>

            </tr>

            <tr>

                <td class="filter-label">
                    Tanggal Akhir
                </td>

                <td>
                    {{ $tanggalAkhir ?: 'Semua' }}
                </td>

            </tr>

            <tr>

                <td class="filter-label">
                    Kategori
                </td>

                <td>
                    {{ $categoryLabel ?? 'Semua Kategori' }}
                </td>

            </tr>

        </table>

    </div>


    <table class="report-table">

        <thead>

            <tr>

                <th width="10%">
                    Peringkat
                </th>

                <th>
                    Nama Produk
                </th>

                <th>
                    SKU
                </th>

                <th>
                    Kategori
                </th>

                <th width="15%">
                    Total Terjual
                </th>

                <th width="12%">
                    Satuan
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($products as $index => $item)

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $item->product->nama_produk ?? '-' }}
                    </td>

                    <td>
                        {{ $item->product->sku ?? '-' }}
                    </td>

                    <td>
                        {{ $item->product->category->nama_kategori ?? '-' }}
                    </td>

                    <td class="text-right">
                        {{ number_format($item->total_terjual, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $item->product->satuan ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center">
                        Belum ada data penjualan.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        Dicetak:
        {{ now()->format('d/m/Y H:i') }}

    </div>

</body>
</html>