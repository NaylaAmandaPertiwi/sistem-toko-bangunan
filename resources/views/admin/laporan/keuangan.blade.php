@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

<style>

/* =========================================================
   LAPORAN KEUANGAN
   ========================================================= */

.finance-page {
    color: #26364d;
}


/* =========================================================
   HEADER
   ========================================================= */

.finance-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 22px;
}

.finance-title h1 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: #17243a;
}

.finance-title p {
    margin: 6px 0 0;
    color: #7b8798;
    font-size: 13px;
}


/* =========================================================
   FILTER
   ========================================================= */

.finance-filter {
    display: flex;
    align-items: center;
    gap: 10px;
}

.date-filter {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1px solid #e3e8f0;
    border-radius: 10px;
    padding: 11px 15px;
    color: #354258;
    font-size: 13px;
}

.date-filter input {
    border: none;
    outline: none;
    color: #354258;
    font-size: 13px;
    background: transparent;
}

/* =========================================================
   QUICK DATE FILTER
   ========================================================= */

.quick-date-wrapper{
    position:relative;
}

.quick-date-button{
    background:#fff;
    color:#354258;
    border:1px solid #e3e8f0;
    min-width:180px;
    justify-content:space-between;
}

.quick-date-arrow{
    font-size:10px;
    margin-left:8px;
}

.quick-date-menu{
    display:none;
    position:absolute;
    top:calc(100% + 8px);
    right:0;
    width:180px;
    background:#fff;
    border:1px solid #e3e8f0;
    border-radius:10px;
    box-shadow:0 5px 18px rgba(30,50,80,.12);
    padding:6px 0;
    z-index:1000;
}

.quick-date-menu.show{
    display:block;
}

.quick-date-menu button{
    width:100%;
    display:block;
    border:none;
    background:#fff;
    color:#26364d;
    text-align:left;
    padding:11px 14px;
    font-size:13px;
    cursor:pointer;
}

.quick-date-menu button:hover{
    background:#f3f6fb;
}

.quick-date-menu button.active{
    background:#eef4ff;
    color:#2463d4;
    font-weight:600;
}

.btn-finance {
    border: none;
    border-radius: 10px;
    padding: 11px 16px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
}

.btn-print {
    background: #dc3545;
    color: #fff;
}

.btn-excel {
    background: #198754;
    color: #fff;
}


/* =========================================================
   TOP SUMMARY
   ========================================================= */

.finance-top-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 18px;
}

.finance-top-card {
    background: #fff;
    border: 1px solid #e7ebf2;
    border-radius: 14px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(30, 50, 80, .03);
}

.finance-icon {
    width: 52px;
    height: 52px;
    min-width: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 700;
}

.icon-blue {
    background: #e8f1ff;
    color: #2463d4;
}

.icon-red {
    background: #ffe9e9;
    color: #dc3545;
}

.icon-green {
    background: #e5f8ed;
    color: #198754;
}

.icon-orange {
    background: #fff1d9;
    color: #e28a00;
}

.finance-top-label {
    font-size: 12px;
    color: #748096;
    margin-bottom: 5px;
}

.finance-top-value {
    font-size: 20px;
    font-weight: 700;
    color: #1d2939;
}


/* =========================================================
   MAIN GRID
   ========================================================= */

.finance-main-grid {
    display: grid;
    grid-template-columns: 1.45fr .85fr .85fr;
    gap: 16px;
    margin-bottom: 18px;
}


/* =========================================================
   PANEL
   ========================================================= */

.finance-panel {
    background: #fff;
    border: 1px solid #e7ebf2;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(30, 50, 80, .03);
}

.finance-panel-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.finance-panel-title h2 {
    margin: 0;
    font-size: 16px;
    color: #1f2d43;
}

.finance-panel-title a {
    font-size: 12px;
    color: #2463d4;
    text-decoration: none;
    font-weight: 600;
}


/* =========================================================
   RINGKASAN KEUANGAN
   ========================================================= */

.finance-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 11px 0;
    border-bottom: 1px solid #edf0f5;
}

.finance-row:last-child {
    border-bottom: none;
}

.finance-row-label {
    color: #536174;
    font-size: 13px;
}

.finance-row-value {
    font-size: 14px;
    font-weight: 600;
    color: #26364d;
}

.finance-row-value.red {
    color: #dc3545;
}

.finance-row-value.green {
    color: #198754;
}

.finance-row-value.blue {
    color: #2463d4;
}


/* Laba */

.profit-box {
    margin-top: 14px;
    background: #f1fbf5;
    border: 1px solid #c9ecd7;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
}

.profit-label {
    font-size: 12px;
    color: #4d7660;
}

.profit-value {
    margin-top: 5px;
    font-size: 23px;
    font-weight: 700;
    color: #198754;
}


/* =========================================================
   RINGKASAN RETUR
   ========================================================= */

.return-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 11px 0;
    border-bottom: 1px solid #edf0f5;
}

.return-row:last-child {
    border-bottom: none;
}

.return-left {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 12px;
    color: #536174;
}

.return-dot {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
}

.return-money {
    background: #ffe9e9;
    color: #dc3545;
}

.return-exchange {
    background: #e8f1ff;
    color: #2463d4;
}

.return-replacement {
    background: #f0e9ff;
    color: #7950c9;
}

.return-difference {
    background: #e5f8ed;
    color: #198754;
}

.return-value {
    font-size: 13px;
    font-weight: 600;
    color: #26364d;
}


/* =========================================================
   ARUS KAS
   ========================================================= */

.cash-box {
    border: 1px solid #e4e9f0;
    border-radius: 11px;
    padding: 13px;
}

.cash-row {
    padding: 9px 0;
}

.cash-row + .cash-row {
    border-top: 1px solid #edf0f5;
}

.cash-label {
    font-size: 12px;
    margin-bottom: 4px;
}

.cash-value {
    font-size: 15px;
    font-weight: 700;
}

.cash-in {
    color: #198754;
}

.cash-out {
    color: #dc3545;
}

.cash-net {
    margin-top: 12px;
    background: #edf4ff;
    border: 1px solid #bcd4ff;
    border-radius: 11px;
    padding: 14px;
}

.cash-net-label {
    font-size: 12px;
    color: #2463d4;
}

.cash-net-value {
    margin-top: 5px;
    font-size: 19px;
    font-weight: 700;
    color: #2463d4;
}


/* =========================================================
   BOTTOM GRID
   ========================================================= */

.finance-bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 18px;
}


/* =========================================================
   TABLE
   ========================================================= */

.finance-table {
    width: 100%;
    border-collapse: collapse;
}

.finance-table th {
    background: #f4f6fa;
    padding: 10px 9px;
    text-align: left;
    font-size: 11px;
    color: #344054;
    white-space: nowrap;
}

.finance-table td {
    padding: 10px 9px;
    border-bottom: 1px solid #edf0f5;
    font-size: 11px;
    color: #536174;
}

.finance-table tr:last-child td {
    border-bottom: none;
}

.text-right {
    text-align: right !important;
}

.text-center {
    text-align: center !important;
}

.amount-green {
    color: #198754 !important;
    font-weight: 600;
}

.amount-red {
    color: #dc3545 !important;
    font-weight: 600;
}


/* =========================================================
   BADGE
   ========================================================= */

.finance-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 8px;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 600;
}

.badge-return {
    background: #fff0f0;
    color: #dc3545;
}

.badge-exchange {
    background: #eef4ff;
    color: #2463d4;
}


/* =========================================================
   INFORMATION
   ========================================================= */

.finance-info {
    background: #eef5ff;
    border: 1px solid #d3e3ff;
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.finance-info-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #2463d4;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    min-width: 24px;
}

.finance-info-text {
    font-size: 11px;
    line-height: 1.6;
    color: #526174;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1100px) {

    .finance-top-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .finance-main-grid {
        grid-template-columns: 1fr;
    }

    .finance-bottom-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 700px) {

    .finance-header {
        flex-direction: column;
        gap: 15px;
    }

    .finance-filter {
        width: 100%;
        flex-wrap: wrap;
    }

    .finance-top-grid {
        grid-template-columns: 1fr;
    }

}
</style>

@section('content')

<div class="finance-page">

    {{-- =====================================================
         HEADER
         ===================================================== --}}

    <div class="finance-header">

        <div class="finance-title">

            <h1>
                Laporan Keuangan
            </h1>

            <p>
                Ringkasan kinerja keuangan berdasarkan transaksi penjualan dan retur.
            </p>

        </div>


        <div class="finance-filter">

            {{-- TANGGAL MULAI & AKHIR --}}
            <div class="date-filter">

                📅

                <input
                    type="date"
                    id="tanggal_mulai"
                    name="tanggal_mulai"
                    value="{{ request('tanggal_mulai') }}"
                >

                <span>–</span>

                <input
                    type="date"
                    id="tanggal_akhir"
                    name="tanggal_akhir"
                    value="{{ request('tanggal_akhir') }}"
                >

            </div>


            {{-- FILTER TANGGAL --}}
            <div class="quick-date-wrapper">

                <button
                    type="button"
                    id="quickDateButton"
                    class="btn-finance quick-date-button"
                >
                    📅
                    <span id="quickDateLabel">
                        @php

                            $filterStart = request('tanggal_mulai');
                            $filterEnd = request('tanggal_akhir');

                            $today = now()->startOfDay();
                            $yesterday = now()->subDay()->startOfDay();
                            $sevenDaysAgo = now()->subDays(6)->startOfDay();
                            $monthStart = now()->startOfMonth();

                        @endphp


                        @if(!$filterStart && !$filterEnd)

                            Semua Tanggal

                        @elseif(
                            $filterStart === $today->format('Y-m-d')
                            &&
                            $filterEnd === $today->format('Y-m-d')
                        )

                            Hari Ini

                        @elseif(
                            $filterStart === $yesterday->format('Y-m-d')
                            &&
                            $filterEnd === $yesterday->format('Y-m-d')
                        )

                            Kemarin

                        @elseif(
                            $filterStart === $sevenDaysAgo->format('Y-m-d')
                            &&
                            $filterEnd === $today->format('Y-m-d')
                        )

                            7 Hari Terakhir

                        @elseif(
                            $filterStart === $monthStart->format('Y-m-d')
                            &&
                            $filterEnd === $today->format('Y-m-d')
                        )

                            Bulan Ini

                        @else

                            Pilih Tanggal...

                        @endif

                    </span>

                    <span class="quick-date-arrow">
                        ▼
                    </span>
                </button>


                <div
                    id="quickDateMenu"
                    class="quick-date-menu"
                >

                    <button
                        type="button"
                        data-filter="all"
                    >
                        Semua Tanggal
                    </button>

                    <button
                        type="button"
                        data-filter="today"
                    >
                        Hari Ini
                    </button>

                    <button
                        type="button"
                        data-filter="yesterday"
                    >
                        Kemarin
                    </button>

                    <button
                        type="button"
                        data-filter="7days"
                    >
                        7 Hari Terakhir
                    </button>

                    <button
                        type="button"
                        data-filter="month"
                    >
                        Bulan Ini
                    </button>

                    <button
                        type="button"
                        data-filter="custom"
                    >
                        Pilih Tanggal...
                    </button>

                </div>

            </div>


            {{-- CETAK PDF --}}
            <a
                href="#"
                id="pdfButton"
                class="btn-finance btn-print"
            >
                🧾 Cetak PDF
            </a>


            {{-- EXPORT EXCEL --}}
            <a
                href="#"
                id="excelButton"
                class="btn-finance btn-excel"
            >
                📊 Export Excel
            </a>

        </div>

    </div>


    {{-- =====================================================
         4 CARD UTAMA
         ===================================================== --}}

    <div class="finance-top-grid">


        {{-- TOTAL PENJUALAN --}}

        <div class="finance-top-card">

            <div class="finance-icon icon-blue">
                🛒
            </div>

            <div>

                <div class="finance-top-label">
                    Total Penjualan
                </div>

                <div class="finance-top-value">

                    Rp {{ number_format(
                        $totalPenjualanBersih,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>


        {{-- TOTAL RETUR --}}

        <div class="finance-top-card">

            <div class="finance-icon icon-red">
                ↩
            </div>

            <div>

                <div class="finance-top-label">
                    Total Retur
                </div>

                <div class="finance-top-value">

                    Rp {{ number_format(
                        $totalRetur,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>


        {{-- KAS MASUK --}}

        <div class="finance-top-card">

            <div class="finance-icon icon-green">
                💵
            </div>

            <div>

                <div class="finance-top-label">
                    Kas Masuk
                </div>

                <div class="finance-top-value">

                    Rp {{ number_format(
                        $totalKasMasuk,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>


        {{-- KAS KELUAR --}}

        <div class="finance-top-card">

            <div class="finance-icon icon-orange">
                💸
            </div>

            <div>

                <div class="finance-top-label">
                    Kas Keluar
                </div>

                <div class="finance-top-value">

                    Rp {{ number_format(
                        $totalKasKeluar,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         3 PANEL UTAMA
         ===================================================== --}}

    <div class="finance-main-grid">


        {{-- =================================================
             RINGKASAN KEUANGAN
             ================================================= --}}

        <div class="finance-panel">

            <div class="finance-panel-title">

                <h2>
                    Ringkasan Keuangan
                </h2>

            </div>


            <div class="finance-row">

                <span class="finance-row-label">
                    Penjualan Bruto
                </span>

                <span class="finance-row-value">

                    Rp {{ number_format(
                        $totalPenjualanBruto,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>


            <div class="finance-row">

                <span class="finance-row-label">
                    Total Diskon
                </span>

                <span class="finance-row-value red">

                    - Rp {{ number_format(
                        $totalDiskon,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>


            <div class="finance-row">

                <span class="finance-row-label">
                    Penjualan Bersih
                </span>

                <span class="finance-row-value blue">

                    Rp {{ number_format(
                        $totalPenjualanBersih,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>


            <div class="finance-row">

                <span class="finance-row-label">
                    HPP
                </span>

                <span class="finance-row-value">

                    - Rp {{ number_format(
                        $totalHpp,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>


            <div class="profit-box">

                <div class="profit-label">
                    Laba Kotor
                </div>

                <div class="profit-value">

                    Rp {{ number_format(
                        $labaKotor,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </div>

        </div>


        {{-- =================================================
             RINGKASAN RETUR
             ================================================= --}}

        <div class="finance-panel">

            <div class="finance-panel-title">

                <h2>
                    Ringkasan Retur
                </h2>

            </div>


            <div class="return-row">

                <div class="return-left">

                    <span class="return-dot return-money">
                        ↩
                    </span>

                    Retur Uang

                </div>

                <span class="return-value">

                    Rp {{ number_format(
                        $totalReturUang,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>


            <div class="return-row">

                <div class="return-left">

                    <span class="return-dot return-exchange">
                        ↔
                    </span>

                    Tukar Barang

                </div>

                <span class="return-value">

                    Rp {{ number_format(
                        $totalTukarBarang,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>


            <div class="return-row">

                <div class="return-left">

                    <span class="return-dot return-replacement">
                        🎁
                    </span>

                    Nilai Barang Pengganti

                </div>

                <span class="return-value">

                    Rp {{ number_format(
                        $totalNilaiPengganti,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>


            <div class="return-row">

                <div class="return-left">

                    <span class="return-dot return-difference">
                        $
                    </span>

                    Selisih Pembayaran

                </div>

                <span class="return-value">

                    Rp {{ number_format(
                        $totalSelisihPembayaran,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>

        </div>


        {{-- =================================================
             ARUS KAS
             ================================================= --}}

        <div class="finance-panel">

            <div class="finance-panel-title">

                <h2>
                    Arus Kas
                </h2>

            </div>


            <div class="cash-box">

                <div class="cash-row">

                    <div class="cash-label cash-in">
                        Kas Masuk
                    </div>

                    <div class="cash-value cash-in">

                        Rp {{ number_format(
                            $totalKasMasuk,
                            0,
                            ',',
                            '.'
                        ) }}

                    </div>

                    <small>
                        Dari selisih tukar barang
                    </small>

                </div>


                <div class="cash-row">

                    <div class="cash-label cash-out">
                        Kas Keluar
                    </div>

                    <div class="cash-value cash-out">

                        Rp {{ number_format(
                            $totalKasKeluar,
                            0,
                            ',',
                            '.'
                        ) }}

                    </div>

                    <small>
                        Dari retur uang
                    </small>

                </div>

            </div>


            <div class="cash-net">

                <div class="cash-net-label">
                    Arus Kas Bersih
                </div>

                <div class="cash-net-value">

                    Rp {{ number_format(
                        $arusKasBersih,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

                <small>
                    Kas Masuk - Kas Keluar
                </small>

            </div>

        </div>

    </div>


    {{-- =====================================================
         2 TABEL RINGKAS
         ===================================================== --}}

    <div class="finance-bottom-grid">


        {{-- =================================================
             TRANSAKSI KEUANGAN TERBARU
             ================================================= --}}

        <div class="finance-panel">

            <div class="finance-panel-title">

                <h2>
                    Ringkasan Retur
                </h2>

                <a href="{{ route('admin.transaksi.retur', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir
                ]) }}">
                    Lihat semua →
                </a>

            </div>


            <div style="overflow-x:auto;">

                <table class="finance-table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>Jenis</th>

                            <th>Referensi</th>

                            <th>Keterangan</th>

                            <th class="text-right">
                                Nominal
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($cashTransactions->take(5) as $index => $transaction)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ $transaction->tanggal->format('d/m/Y') }}
                                </td>

                                <td>

                                    @if($transaction->jenis === 'masuk')

                                        <span class="finance-badge badge-exchange">
                                            Tukar Barang
                                        </span>

                                    @else

                                        <span class="finance-badge badge-return">
                                            Retur Uang
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $transaction->referensi ?? '-' }}
                                </td>

                                <td>
                                    {{ $transaction->keterangan ?? '-' }}
                                </td>

                                <td class="text-right
                                    {{ $transaction->jenis === 'masuk'
                                        ? 'amount-green'
                                        : 'amount-red' }}"
                                >

                                    {{ $transaction->jenis === 'masuk'
                                        ? 'Rp '
                                        : '- Rp ' }}

                                    {{ number_format(
                                        $transaction->nominal,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center"
                                >
                                    Belum ada transaksi kas.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =================================================
             RINGKASAN PENJUALAN
             ================================================= --}}

        <div class="finance-panel">

            <div class="finance-panel-title">

                <h2>
                    Ringkasan Penjualan
                </h2>

                <a href="{{ route('admin.transaksi.penjualan', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir
                ]) }}">
                    Lihat semua →
                </a>

            </div>


            <div style="overflow-x:auto;">

                <table class="finance-table">

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

                        @forelse($sales->take(5) as $index => $sale)

                            @php

                                $hpp = $sale->saleDetails->sum(function ($detail) {

                                    return $detail->qty *
                                           ($detail->product->harga_beli ?? 0);

                                });

                                $laba = $sale->total_bayar - $hpp;

                            @endphp

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse(
                                        $sale->tanggal
                                    )->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ $sale->kode_penjualan }}
                                </td>

                                <td>
                                    {{ $sale->user->name ?? '-' }}
                                </td>

                                <td>
                                    Rp {{ number_format(
                                        $sale->total_bayar,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td>
                                    Rp {{ number_format(
                                        $sale->diskon ?? 0,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td>
                                    Rp {{ number_format(
                                        $hpp,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </td>

                                <td class="amount-green">

                                    Rp {{ number_format(
                                        $laba,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

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

            </div>

        </div>

    </div>


    {{-- =====================================================
         INFORMASI
         ===================================================== --}}

    <div class="finance-info">

        <div class="finance-info-icon">
            i
        </div>

        <div class="finance-info-text">

            <strong>
                Informasi Laporan
            </strong>

            <br>

            Laporan keuangan ini dihitung berdasarkan transaksi
            penjualan, retur, dan pencatatan kas pada periode
            yang dipilih. Kas masuk berasal dari selisih pembayaran
            tukar barang, sedangkan kas keluar berasal dari retur uang.

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const tanggalMulai =
        document.getElementById('tanggal_mulai');

    const tanggalAkhir =
        document.getElementById('tanggal_akhir');

    const quickDateButton =
        document.getElementById('quickDateButton');

    const quickDateMenu =
        document.getElementById('quickDateMenu');

    const quickDateLabel =
        document.getElementById('quickDateLabel');

    const pdfButton =
        document.getElementById('pdfButton');

    const excelButton =
        document.getElementById('excelButton');


    /*
    |--------------------------------------------------------------------------
    | URL FILTER
    |--------------------------------------------------------------------------
    */

    function applyFilter(start = '', end = '') {

        const params =
            new URLSearchParams();


        if (start !== '') {

            params.set(
                'tanggal_mulai',
                start
            );

        }


        if (end !== '') {

            params.set(
                'tanggal_akhir',
                end
            );

        }


        const baseUrl =
            '{{ route('admin.laporan.keuangan') }}';


        window.location.href =
            baseUrl +
            (
                params.toString()
                    ? '?' + params.toString()
                    : ''
            );

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE URL PDF
    |--------------------------------------------------------------------------
    */

    function updateExportUrl() {

        const params =
            new URLSearchParams();


        if (tanggalMulai.value !== '') {

            params.set(
                'tanggal_mulai',
                tanggalMulai.value
            );

        }


        if (tanggalAkhir.value !== '') {

            params.set(
                'tanggal_akhir',
                tanggalAkhir.value
            );

        }


        const query =
            params.toString();


        pdfButton.href =
            '{{ route('admin.laporan.keuangan.pdf') }}' +
            (
                query
                    ? '?' + query
                    : ''
            );


        excelButton.href =
            '{{ route('admin.laporan.keuangan.excel') }}' +
            (
                query
                    ? '?' + query
                    : ''
            );

    }


    /*
    |--------------------------------------------------------------------------
    | TANGGAL MULAI / AKHIR = LIVE
    |--------------------------------------------------------------------------
    */

    tanggalMulai.addEventListener(
        'change',
        function () {

            applyFilter(
                tanggalMulai.value,
                tanggalAkhir.value
            );

        }
    );


    tanggalAkhir.addEventListener(
        'change',
        function () {

            applyFilter(
                tanggalMulai.value,
                tanggalAkhir.value
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | BUKA / TUTUP DROPDOWN
    |--------------------------------------------------------------------------
    */

    quickDateButton.addEventListener(
        'click',
        function (event) {

            event.stopPropagation();

            quickDateMenu.classList.toggle('show');

        }
    );


    /*
    |--------------------------------------------------------------------------
    | PILIH FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    quickDateMenu
        .querySelectorAll('button')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const filter =
                        this.dataset.filter;


                    const today =
                        new Date();


                    let start = '';
                    let end = '';


                    /*
                    | SEMUA TANGGAL
                    */

                    if (filter === 'all') {

                        quickDateLabel.textContent =
                            'Semua Tanggal';

                        applyFilter();

                        return;

                    }


                    /*
                    | HARI INI
                    */

                    if (filter === 'today') {

                        start =
                            formatDate(today);

                        end =
                            formatDate(today);

                        quickDateLabel.textContent =
                            'Hari Ini';

                    }


                    /*
                    | KEMARIN
                    */

                    if (filter === 'yesterday') {

                        const yesterday =
                            new Date(today);

                        yesterday.setDate(
                            today.getDate() - 1
                        );

                        start =
                            formatDate(yesterday);

                        end =
                            formatDate(yesterday);

                        quickDateLabel.textContent =
                            'Kemarin';

                    }


                    /*
                    | 7 HARI TERAKHIR
                    */

                    if (filter === '7days') {

                        const sevenDaysAgo =
                            new Date(today);

                        sevenDaysAgo.setDate(
                            today.getDate() - 6
                        );

                        start =
                            formatDate(sevenDaysAgo);

                        end =
                            formatDate(today);

                        quickDateLabel.textContent =
                            '7 Hari Terakhir';

                    }


                    /*
                    | BULAN INI
                    */

                    if (filter === 'month') {

                        const firstDay =
                            new Date(
                                today.getFullYear(),
                                today.getMonth(),
                                1
                            );

                        start =
                            formatDate(firstDay);

                        end =
                            formatDate(today);

                        quickDateLabel.textContent =
                            'Bulan Ini';

                    }


                    /*
                    | PILIH TANGGAL
                    */

                    if (filter === 'custom') {

                        quickDateLabel.textContent =
                            'Pilih Tanggal...';

                        quickDateMenu.classList.remove(
                            'show'
                        );

                        tanggalMulai.focus();

                        return;

                    }


                    /*
                    | MASUKKAN TANGGAL
                    */

                    tanggalMulai.value =
                        start;

                    tanggalAkhir.value =
                        end;


                    quickDateMenu.classList.remove(
                        'show'
                    );


                    applyFilter(
                        start,
                        end
                    );

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | FORMAT DATE
    |--------------------------------------------------------------------------
    */

    function formatDate(date) {

        const year =
            date.getFullYear();

        const month =
            String(
                date.getMonth() + 1
            ).padStart(2, '0');

        const day =
            String(
                date.getDate()
            ).padStart(2, '0');


        return (
            year +
            '-' +
            month +
            '-' +
            day
        );

    }


    /*
    |--------------------------------------------------------------------------
    | KLIK DI LUAR DROPDOWN
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !quickDateButton.contains(event.target) &&
                !quickDateMenu.contains(event.target)
            ) {

                quickDateMenu.classList.remove(
                    'show'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | URL PDF & EXCEL SAAT HALAMAN DIBUKA
    |--------------------------------------------------------------------------
    */

    updateExportUrl();

});

</script>

@endsection