<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Keuangan</title>

    <style>

        @page {
            margin: 25px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header h2 {
            margin: 4px 0;
            font-size: 12px;
        }

        .header p {
            margin: 0;
            font-size: 8px;
            color: #666;
        }

        .periode {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .periode td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .periode .label {
            width: 100px;
            font-weight: bold;
            background: #f4f6fb;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .summary td {
            width: 25%;
            border: 1px solid #ddd;
            padding: 8px;
        }

        .summary-label {
            font-size: 8px;
            color: #666;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 11px;
            font-weight: bold;
        }

        .summary-green {
            color: #16884a;
        }

        .summary-red {
            color: #dc3545;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 7px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .detail-table td {
            border-bottom: 1px solid #ddd;
            padding: 6px;
        }

        .detail-table .label {
            color: #555;
        }

        .detail-table .value {
            text-align: right;
            font-weight: bold;
        }

        .profit-box {
            border: 1px solid #bde5cc;
            background: #eefaf2;
            padding: 10px;
            text-align: center;
            margin-top: 8px;
        }

        .profit-label {
            font-size: 8px;
            color: #16884a;
        }

        .profit-value {
            font-size: 15px;
            font-weight: bold;
            color: #16884a;
        }

        .return-table,
        .sales-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .return-table th,
        .sales-table th {
            background: #355cc9;
            color: white;
            border: 1px solid #294aa5;
            padding: 6px;
            font-size: 8px;
            text-align: center;
        }

        .return-table td,
        .sales-table td {
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 8px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .green {
            color: #16884a;
        }

        .red {
            color: #dc3545;
        }

        .cash-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .cash-box td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .cash-in {
            color: #16884a;
        }

        .cash-out {
            color: #dc3545;
        }

        .cash-net {
            color: #2563eb;
            font-weight: bold;
        }

        .footer {
            margin-top: 15px;
            font-size: 8px;
            color: #777;
            text-align: right;
        }

    </style>

</head>

<body>

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="header">

        <h1>LAPORAN KEUANGAN</h1>

        <h2>Nayla Bangunan</h2>

        <p>
            Ringkasan kinerja keuangan berdasarkan transaksi
            penjualan, retur, dan pencatatan kas.
        </p>

    </div>


    {{-- =====================================================
         PERIODE
    ====================================================== --}}

    <table class="periode">

        <tr>

            <td class="label">
                Periode
            </td>

            <td>

                @if($tanggalMulai && $tanggalAkhir)

                    {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}

                    -

                    {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}

                @else

                    Semua Tanggal

                @endif

            </td>

        </tr>

    </table>


    {{-- =====================================================
         4 CARD UTAMA
    ====================================================== --}}

    <table class="summary">

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
                    Total Retur
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalRetur, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Kas Masuk
                </div>

                <div class="summary-value summary-green">
                    Rp {{ number_format($totalKasMasuk, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    Kas Keluar
                </div>

                <div class="summary-value summary-red">
                    Rp {{ number_format($totalKasKeluar, 0, ',', '.') }}
                </div>

            </td>

        </tr>

    </table>


    {{-- =====================================================
         RINGKASAN KEUANGAN
    ====================================================== --}}

    <div class="section-title">
        Ringkasan Keuangan
    </div>

    <table class="detail-table">

        <tr>

            <td class="label">
                Penjualan Bruto
            </td>

            <td class="value">
                Rp {{ number_format($totalPenjualanBruto, 0, ',', '.') }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Total Diskon
            </td>

            <td class="value red">
                - Rp {{ number_format($totalDiskon, 0, ',', '.') }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Penjualan Bersih
            </td>

            <td class="value">
                Rp {{ number_format($totalPenjualanBersih, 0, ',', '.') }}
            </td>

        </tr>


        <tr>

            <td class="label">
                HPP
            </td>

            <td class="value">
                - Rp {{ number_format($totalHpp, 0, ',', '.') }}
            </td>

        </tr>

    </table>


    <div class="profit-box">

        <div class="profit-label">
            Laba Kotor
        </div>

        <div class="profit-value">
            Rp {{ number_format($labaKotor, 0, ',', '.') }}
        </div>

    </div>


    {{-- =====================================================
         RINGKASAN RETUR
    ====================================================== --}}

    <div class="section-title">
        Ringkasan Retur
    </div>

    <table class="detail-table">

        <tr>

            <td class="label">
                Retur Uang
            </td>

            <td class="value">
                Rp {{ number_format($totalReturUang, 0, ',', '.') }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Tukar Barang
            </td>

            <td class="value">
                Rp {{ number_format($totalTukarBarang, 0, ',', '.') }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Nilai Barang Pengganti
            </td>

            <td class="value">
                Rp {{ number_format($totalNilaiPengganti, 0, ',', '.') }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Selisih Pembayaran
            </td>

            <td class="value green">
                Rp {{ number_format($totalSelisihPembayaran, 0, ',', '.') }}
            </td>

        </tr>

    </table>


    {{-- =====================================================
         ARUS KAS
    ====================================================== --}}

    <div class="section-title">
        Arus Kas
    </div>

    <table class="cash-box">

        <tr>

            <td class="cash-in">
                <strong>Kas Masuk</strong>
                <br>
                Rp {{ number_format($totalKasMasuk, 0, ',', '.') }}
                <br>
                <small>Dari selisih pembayaran tukar barang</small>
            </td>


            <td class="cash-out">
                <strong>Kas Keluar</strong>
                <br>
                Rp {{ number_format($totalKasKeluar, 0, ',', '.') }}
                <br>
                <small>Dari retur uang</small>
            </td>


            <td class="cash-net">

                <strong>Arus Kas Bersih</strong>

                <br>

                Rp {{ number_format($arusKasBersih, 0, ',', '.') }}

                <br>

                <small>
                    Kas Masuk - Kas Keluar
                </small>

            </td>

        </tr>

    </table>


    {{-- =====================================================
         RINGKASAN RETUR - DATA
    ====================================================== --}}

    <div class="section-title">
        Ringkasan Retur
    </div>

    <table class="return-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Retur</th>
                <th>Kode Penjualan</th>
                <th>Kasir</th>
                <th>Jenis Retur</th>
                <th>Total Retur</th>
                <th>Nilai Pengganti</th>
                <th>Selisih</th>

            </tr>

        </thead>

        <tbody>

            @forelse($returns as $index => $return)

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($return->tanggal)->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $return->kode_retur }}
                    </td>

                    <td>
                        {{ $return->sale->kode_penjualan ?? '-' }}
                    </td>

                    <td>
                        {{ $return->user->name ?? '-' }}
                    </td>

                    <td>
                        {{ $return->return_type === 'uang'
                            ? 'Retur Uang'
                            : 'Tukar Barang' }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($return->total_retur, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($return->total_pengganti ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($return->selisih_bayar ?? 0, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="9" class="text-center">
                        Belum ada transaksi retur.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    {{-- =====================================================
         RINGKASAN PENJUALAN
    ====================================================== --}}

    <div class="section-title">
        Ringkasan Penjualan
    </div>

    <table class="sales-table">

        <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>No Penjualan</th>
                <th>Kasir</th>
                <th>Penjualan Bersih</th>
                <th>Diskon</th>
                <th>HPP</th>
                <th>Laba</th>

            </tr>

        </thead>

        <tbody>

            @forelse($sales as $index => $sale)

                @php

                    $hpp = $sale->saleDetails->sum(function ($detail) {

                        return $detail->qty *
                               ($detail->product->harga_beli ?? 0);

                    });

                    $laba = $sale->total_bayar - $hpp;

                @endphp

                <tr>

                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td class="text-center">
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
                        Rp {{ number_format($sale->diskon ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($hpp, 0, ',', '.') }}
                    </td>

                    <td class="text-right green">
                        Rp {{ number_format($laba, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center">
                        Belum ada data penjualan.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        Dicetak pada
        {{ now()->format('d/m/Y H:i') }}

    </div>

</body>

</html>