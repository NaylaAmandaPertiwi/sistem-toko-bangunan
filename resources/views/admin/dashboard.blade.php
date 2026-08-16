@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<style>

    /* =========================================================
    HEADER DASHBOARD ADMIN
    ========================================================= */

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;

        margin-bottom: 25px;
        gap: 25px;
    }


    /* =========================
    BAGIAN KIRI
    ========================= */

    .dashboard-header-left h2 {
        margin: 0 0 8px 0;

        font-size: 32px;
        font-weight: 700;

        color: #183153;
    }

    .dashboard-header-left p {
        margin: 0;

        font-size: 16px;

        color: #6b7a90;
    }

    .dashboard-header-left p strong {
        color: #2456c5;
    }


    /* =========================
    BAGIAN KANAN
    ========================= */

    .dashboard-header-right {
        display: flex;
        align-items: center;

        gap: 14px;
    }


    /* =========================
    CARD INFO
    ========================= */

    .header-info-card {
        min-width: 185px;

        min-height: 72px;

        padding: 10px 18px;

        background: #ffffff;

        border-radius: 28px;

        display: flex;
        align-items: center;

        gap: 14px;

        box-shadow:
            0 4px 15px rgba(30, 60, 100, 0.08);

        border: 1px solid #edf1f7;
    }


    /* =========================
    ICON
    ========================= */

    .header-icon {
        width: 42px;
        height: 42px;

        border-radius: 50%;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 18px;

        flex-shrink: 0;
    }


    /* Notifikasi */

    .notification-icon {
        background: #eef4ff;
        color: #315fd4;
    }


    /* Kalender */

    .calendar-icon {
        background: #eef4ff;
        color: #315fd4;
    }


    /* Jam */

    .clock-icon {
        background: #eef4ff;
        color: #315fd4;
    }

    /* =========================================================
    DATE PICKER DASHBOARD
    ========================================================= */

    .dashboard-date-card {
        position: relative;

        cursor: pointer;
    }


    /*
    |--------------------------------------------------------------------------
    | Tampilan tanggal
    |--------------------------------------------------------------------------
    */

    .dashboard-date-display {
        font-size: 13px;

        color: #65758b;

        cursor: pointer;
    }


    /*
    |--------------------------------------------------------------------------
    | Input date transparan
    |--------------------------------------------------------------------------
    */

    #dashboardDatePicker {
        position: absolute;

        inset: 0;

        width: 100%;
        height: 100%;

        opacity: 0;

        cursor: pointer;

        border: none;

        z-index: 20;
    }


    /*
    |--------------------------------------------------------------------------
    | Efek hover
    |--------------------------------------------------------------------------
    */

    .dashboard-date-card:hover {
        box-shadow:
            0 6px 20px rgba(30, 60, 100, 0.12);

        transform: translateY(-1px);

        transition: 0.2s ease;
    }


    /* =========================
    TEKS
    ========================= */

    .header-info-text {
        display: flex;

        flex-direction: column;

        gap: 3px;

        line-height: 1.3;
    }

    .header-info-text strong {
        font-size: 15px;

        font-weight: 600;

        color: #183153;
    }

    .header-info-text span {
        font-size: 13px;

        color: #65758b;
    }


    /* =========================
    JAM
    ========================= */

    .clock-card {
        min-width: 175px;
    }

    #currentTime {
        font-size: 22px;

        font-weight: 700;

        color: #315fd4;
    }


    /* =========================
    STATUS LIVE
    ========================= */

    .live-status {
        display: inline-flex !important;

        align-items: center;

        width: fit-content;

        padding: 3px 10px;

        border-radius: 20px;

        background: #dcfce7;

        color: #16a34a !important;

        font-size: 12px !important;

        font-weight: 600;
    }

    .live-dot {
        width: 6px;
        height: 6px;

        margin-right: 5px;

        border-radius: 50%;

        background: #16a34a;
    }


    /* =========================================================
    RESPONSIVE
    ========================================================= */

    @media (max-width: 1100px) {

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .dashboard-header-right {
            width: 100%;
            flex-wrap: wrap;
        }

    }


    @media (max-width: 700px) {

        .header-info-card {
            flex: 1;
            min-width: 160px;
        }

    }


    /* =========================================================
       STATISTIC CARDS
    ========================================================= */

    .dashboard-statistics {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .dashboard-stat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 18px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
        min-height: 110px;
        position: relative;
        overflow: hidden;
    }

    .dashboard-stat-card .stat-title {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .dashboard-stat-card .stat-value {
        font-size: 23px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .dashboard-stat-card .stat-description {
        margin-top: 6px;
        font-size: 11px;
        color: #9ca3af;
    }

    .stat-icon {
        position: absolute;
        right: 15px;
        top: 15px;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        font-weight: 700;
    }

    .stat-blue .stat-icon {
        background: #e8f0ff;
        color: #355cc9;
    }

    .stat-green .stat-icon {
        background: #e8f8ef;
        color: #20a05a;
    }

    .stat-purple .stat-icon {
        background: #f0eaff;
        color: #7c4dce;
    }

    .stat-orange .stat-icon {
        background: #fff1df;
        color: #f59e0b;
    }

    .stat-red .stat-icon {
        background: #ffe9eb;
        color: #e5484d;
    }


    /* =========================================================
       MAIN GRID
    ========================================================= */

    .dashboard-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(360px, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .dashboard-bottom-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(360px, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .dashboard-extra-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(360px, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }


    /* =========================================================
       DASHBOARD BOX
    ========================================================= */

    .dashboard-box {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
        padding: 20px;
    }

    .dashboard-box-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .dashboard-box-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #111827;
    }

    .dashboard-box-header span {
        font-size: 11px;
        color: #6b7280;
    }


    /* =========================================================
       GRAFIK
    ========================================================= */

    .sales-chart-container {
        position: relative;
        width: 100%;
        height: 310px;
    }


    /* =========================================================
       STOCK WARNING
    ========================================================= */

    .stock-table {
        width: 100%;
        border-collapse: collapse;
    }

    .stock-table th {
        background: #f5f7fb;
        color: #374151;
        font-size: 12px;
        font-weight: 600;
        padding: 11px 10px;
        text-align: left;
    }

    .stock-table td {
        padding: 11px 10px;
        border-bottom: 1px solid #edf0f4;
        font-size: 12px;
        color: #374151;
    }

    .stock-table tr:last-child td {
        border-bottom: none;
    }

    .stock-number {
        font-weight: 700;
        color: #dc3545;
    }

    .stock-minimum {
        color: #6b7280;
    }

    .badge-danger {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 20px;
        background: #ffe5e7;
        color: #d9303e;
        font-size: 10px;
        font-weight: 600;
    }

    .badge-safe {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 20px;
        background: #e5f8ed;
        color: #1c9b54;
        font-size: 10px;
        font-weight: 600;
    }


    /* =========================================================
       TRANSAKSI TERBARU
    ========================================================= */

    .transaction-table {
        width: 100%;
        border-collapse: collapse;
    }

    .transaction-table th {
        background: #f5f7fb;
        padding: 11px 10px;
        font-size: 11px;
        color: #374151;
        text-align: left;
    }

    .transaction-table td {
        padding: 11px 10px;
        font-size: 11px;
        color: #374151;
        border-bottom: 1px solid #edf0f4;
    }

    .transaction-table tr:last-child td {
        border-bottom: none;
    }

    .transaction-code {
        font-weight: 600;
        color: #355cc9;
    }

    .badge-success {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 20px;
        background: #e3f7eb;
        color: #1c9b54;
        font-size: 10px;
        font-weight: 600;
    }


    /* =========================================================
       PRODUK TERLARIS
    ========================================================= */

    .top-product-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
        min-height: 280px;
    }

    .top-product-chart {
        width: 210px;
        height: 210px;
        flex-shrink: 0;
        position: relative;
    }

    .top-product-list {
        flex: 1;
        min-width: 0;
    }

    .top-product-item {
        display: grid;
        grid-template-columns: 10px minmax(0, 1fr) auto auto;
        align-items: center;
        gap: 8px;
        margin-bottom: 13px;
    }

    .top-product-item:last-child {
        margin-bottom: 0;
    }

    .product-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .product-name {
        font-size: 11px;
        color: #374151;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-qty {
        font-size: 11px;
        color: #111827;
        font-weight: 600;
        white-space: nowrap;
    }

    .product-percent {
        font-size: 10px;
        color: #6b7280;
        width: 32px;
        text-align: right;
    }

    .top-product-total {
        border-top: 1px solid #e5e7eb;
        margin-top: 18px;
        padding-top: 13px;
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
    }

    .top-product-total strong {
        color: #111827;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1200px) {

        .dashboard-statistics {
            grid-template-columns: repeat(3, 1fr);
        }

        .dashboard-main-grid,
        .dashboard-bottom-grid,
        .dashboard-extra-grid {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 700px) {

        .dashboard-statistics {
            grid-template-columns: 1fr;
        }

        .top-product-wrapper {
            flex-direction: column;
        }

        .top-product-chart {
            width: 180px;
            height: 180px;
        }

    }

</style>


<!-- =========================================================
     HEADER DASHBOARD ADMIN
========================================================= -->

<div class="dashboard-header">

    <!-- BAGIAN KIRI -->
    <div class="dashboard-header-left">

        <h2>Dashboard Admin</h2>

        <p>
            Selamat datang kembali,
            <strong>Admin</strong> 👋
        </p>

    </div>


    <!-- BAGIAN KANAN -->
    <div class="dashboard-header-right">

        <!-- NOTIFIKASI -->
        <div class="header-info-card">

            <div class="header-icon notification-icon">
                <i class="fas fa-bell"></i>
            </div>

            <div class="header-info-text">

                <strong>Notifikasi</strong>

                @if($stokMenipis->count() > 0)

                    <span>
                        {{ $stokMenipis->count() }} produk stok menipis
                    </span>

                @else

                    <span>
                        Semua stok aman
                    </span>

                @endif

            </div>

        </div>

        <!-- TANGGAL DASHBOARD -->
        <div
            class="header-info-card dashboard-date-card"
            onclick="openDashboardDatePicker()"
        >

            <div class="header-icon calendar-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>

            <div class="header-info-text">

                <strong id="currentDay">
                    -
                </strong>

                <span
                    id="currentDate"
                    class="dashboard-date-display"
                >
                    -
                </span>

            </div>

            <!-- DATE PICKER -->
            <input
                type="date"
                id="dashboardDatePicker"
                value="{{ $data['tanggal_dipilih'] ?? now()->format('Y-m-d') }}"
                aria-label="Pilih tanggal dashboard"
            >

        </div>


        <!-- JAM -->
        <div class="header-info-card clock-card">

            <div class="header-icon clock-icon">
                <i class="fas fa-clock"></i>
            </div>

            <div class="header-info-text">

                <strong id="currentTime">
                    00:00:00
                </strong>

                <span class="live-status">
                    <span class="live-dot"></span>
                    LIVE
                </span>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     STATISTIK
========================================================= -->

<div class="dashboard-statistics">

    <!-- TOTAL PRODUK -->

    <div class="dashboard-stat-card stat-blue">

        <div class="stat-icon">
            📦
        </div>

        <div class="stat-title">
            Total Produk
        </div>

        <p class="stat-value">
            {{ $data['total_produk'] ?? 0 }}
        </p>

        <div class="stat-description">
            Semua produk
        </div>

    </div>


    <!-- TOTAL KATEGORI -->

    <div class="dashboard-stat-card stat-green">

        <div class="stat-icon">
            🗂️
        </div>

        <div class="stat-title">
            Total Kategori
        </div>

        <p class="stat-value">
            {{ $data['total_kategori'] ?? 0 }}
        </p>

        <div class="stat-description">
            Semua kategori
        </div>

    </div>


    <!-- PENJUALAN HARI INI -->

    <div class="dashboard-stat-card stat-purple">

        <div class="stat-icon">
            🛒
        </div>

        <div class="stat-title">
            Penjualan Hari Ini
        </div>

        <p class="stat-value">
            Rp {{ number_format($data['total_penjualan'] ?? 0, 0, ',', '.') }}
        </p>

        <div class="stat-description">
            Total penjualan
        </div>

    </div>


    <!-- TRANSAKSI HARI INI -->

    <div class="dashboard-stat-card stat-orange">

        <div class="stat-icon">
            🧾
        </div>

        <div class="stat-title">
            Transaksi Hari Ini
        </div>

        <p class="stat-value">
            {{ $data['total_transaksi'] ?? 0 }}
        </p>

        <div class="stat-description">
            Total transaksi
        </div>

    </div>


    <!-- STOK MENIPIS -->

    <div class="dashboard-stat-card stat-red">

        <div class="stat-icon">
            ⚠
        </div>

        <div class="stat-title">
            Stok Menipis
        </div>

        <p class="stat-value">
            {{ $stokMenipis->count() }}
        </p>

        <div class="stat-description">
            Produk perlu diperhatikan
        </div>

    </div>

</div>


<!-- =========================================================
     GRAFIK + PERINGATAN STOK
========================================================= -->

<div class="dashboard-main-grid">


    <!-- GRAFIK PENJUALAN -->

    <div class="dashboard-box">

        <div class="dashboard-box-header">

            <h3>
                Grafik Penjualan 7 Hari Terakhir
            </h3>

            <span>
                7 Hari Terakhir
            </span>

        </div>

        <div class="sales-chart-container">

            <canvas id="salesChart"></canvas>

        </div>

    </div>


    <!-- PERINGATAN STOK -->

    <div class="dashboard-box">

        <div class="dashboard-box-header">

            <h3>
                Stok Menipis
            </h3>

            <span>
                {{ $stokMenipis->count() }} Produk
            </span>

        </div>


        <table class="stock-table">

            <thead>

                <tr>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>Minimum</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

                @forelse($stokMenipis as $product)

                    <tr>

                        <td>
                            {{ $product->nama_produk }}
                        </td>

                        <td>
                            <span class="stock-number">
                                {{ $product->stok }}
                            </span>
                        </td>

                        <td>
                            <span class="stock-minimum">
                                {{ $product->stok_minimum }}
                            </span>
                        </td>

                        <td>

                            <span class="badge-danger">
                                Menipis
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" style="text-align:center;">
                            <span class="badge-safe">
                                Semua stok aman
                            </span>
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<!-- =========================================================
     TRANSAKSI TERBARU + PRODUK TERLARIS
========================================================= -->

<div class="dashboard-bottom-grid">

    @php

        $produkTerlaris =
            $data['produk_terlaris'] ?? collect();

    @endphp

    <!-- TRANSAKSI TERBARU -->

    <div class="dashboard-box">

        <div class="dashboard-box-header">

            <h3>
                Transaksi Terbaru
            </h3>

            <span>
                Transaksi terakhir
            </span>

        </div>


        <table class="transaction-table">

            <thead>

                <tr>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

                @forelse(($transaksiTerakhir ?? collect()) as $sale)

                    <tr>

                        <td class="transaction-code">
                            {{ $sale->kode_penjualan }}
                        </td>

                        <td>
                            {{ Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $sale->user->name ?? '-' }}
                        </td>

                        <td>
                            Rp {{ number_format($sale->total_bayar, 0, ',', '.') }}
                        </td>

                        <td>

                            <span class="badge-success">
                                Selesai
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" style="text-align:center;">
                            Belum ada transaksi.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PRODUK TERLARIS -->

    <div class="dashboard-box">

        <div class="dashboard-box-header">

            <h3>
                Produk Terlaris
            </h3>

            <span>
                5 Produk Teratas
            </span>

        </div>


        <div class="top-product-wrapper">


            <!-- DONUT CHART -->

            <div class="top-product-chart">

                <canvas id="topProductChart"></canvas>

            </div>


            <!-- LIST PRODUK -->

            <div class="top-product-list">

                @php

                    $totalProdukTerjual =
                        $produkTerlaris->sum('total_terjual');

                @endphp


                @forelse($produkTerlaris as $index => $product)

                    @php

                        $persentase = $totalProdukTerjual > 0
                            ? round(
                                ($product->total_terjual / $totalProdukTerjual) * 100
                            )
                            : 0;

                    @endphp


                    <div class="top-product-item">

                        <span
                            class="product-dot"
                            style="
                                background:
                                {{
                                    [
                                        '#355cc9',
                                        '#20a05a',
                                        '#7c4dce',
                                        '#f59e0b',
                                        '#e5484d'
                                    ][$index] ?? '#999999'
                                }};
                            ">
                        </span>

                        <span class="product-name">

                            {{ $product->nama_produk }}

                        </span>

                        <span class="product-qty">

                            {{ number_format($product->total_terjual, 0, ',', '.') }}

                        </span>

                        <span class="product-percent">

                            {{ $persentase }}%

                        </span>

                    </div>

                @empty

                    <div style="font-size:12px;color:#6b7280;">
                        Belum ada data produk terjual.
                    </div>

                @endforelse


                <!-- TOTAL -->

                <div class="top-product-total">

                    <span>
                        Total Terjual
                    </span>

                    <strong>
                        {{ number_format($totalProdukTerjual ?? 0, 0, ',', '.') }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =========================================================
     RETUR TERBARU + DISKON AKTIF
========================================================= -->

<div class="dashboard-extra-grid">

    <!-- RETUR TERBARU -->

    <div class="dashboard-box">

        <div class="dashboard-box-header">

            <h3>
                Retur Terbaru
            </h3>

            <span>
                {{ $returTerbaru->count() }} Retur Terbaru
            </span>

        </div>

        <table class="transaction-table">

            <thead>

                <tr>
                    <th>Kode Retur</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Total Retur</th>
                    <th>Keterangan</th>
                </tr>

            </thead>

            <tbody>

                @forelse($returTerbaru as $retur)

                    <tr>

                        <td>
                            {{ $retur->kode_retur }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($retur->tanggal)->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $retur->user->name ?? '-' }}
                        </td>

                        <td>
                            Rp {{ number_format($retur->total_retur, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $retur->keterangan ?: '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" style="text-align:center;">
                            Belum ada retur.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- DISKON AKTIF -->

    <div class="dashboard-box">

        <div class="dashboard-box-header">

            <h3>
                Diskon Aktif
            </h3>

            <span>
                {{ $diskonAktif->count() }} Diskon
            </span>

        </div>


        <table class="transaction-table">

            <thead>

                <tr>

                    <th>
                        Nama Diskon
                    </th>

                    <th>
                        Minimal Belanja
                    </th>

                    <th>
                        Diskon
                    </th>

                    <th>
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($diskonAktif as $diskon)

                    <tr>

                        <td>
                            {{ $diskon->nama_diskon }}
                        </td>

                        <td>
                            Rp {{ number_format($diskon->minimal_belanja, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $diskon->persentase_diskon }}%
                        </td>

                        <td>

                            <span class="badge-success">
                                {{ strtoupper($diskon->status) }}
                            </span>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" style="text-align:center;">
                            Tidak ada diskon aktif.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>




@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

/* =========================================================
   GRAFIK PENJUALAN 7 HARI
========================================================= */

const ctx = document.getElementById('salesChart');

if (ctx) {

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: @json($data['grafik_labels'] ?? []),

            datasets: [{

                label: 'Penjualan',

                data: @json($data['grafik_data'] ?? []),

                borderColor: '#355cc9',

                backgroundColor: 'rgba(53, 92, 201, 0.08)',

                tension: 0.4,

                fill: true,

                pointRadius: 4,

                pointHoverRadius: 6

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return 'Rp ' +
                                new Intl.NumberFormat('id-ID')
                                    .format(context.raw);

                        }

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function(value) {

                            return 'Rp ' +
                                new Intl.NumberFormat('id-ID')
                                    .format(value);

                        }

                    }

                }

            }

        }

    });

}

/* =========================================================
   GRAFIK PRODUK TERLARIS
========================================================= */

const topProductCanvas =
    document.getElementById('topProductChart');

if (topProductCanvas) {

    const topProductLabels =
        @json(
            $produkTerlaris->pluck('nama_produk')->values()
        );

    const topProductData =
        @json(
            $produkTerlaris->pluck('total_terjual')->values()
        );

    new Chart(topProductCanvas, {

        type: 'doughnut',

        data: {

            labels: topProductLabels,

            datasets: [{

                data: topProductData,

                backgroundColor: [
                    '#355cc9',
                    '#20a05a',
                    '#7c4dce',
                    '#f59e0b',
                    '#e5484d'
                ],

                borderWidth: 0,

                hoverOffset: 5

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            cutout: '58%',

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            const value =
                                new Intl.NumberFormat('id-ID')
                                    .format(context.raw);

                            return ' ' + value + ' terjual';

                        }

                    }

                }

            }

        }

    });

}

/* =========================================================
   TANGGAL DASHBOARD
========================================================= */

function updateDashboardDate() {

    const datePicker =
        document.getElementById('dashboardDatePicker');

    const currentDay =
        document.getElementById('currentDay');

    const currentDate =
        document.getElementById('currentDate');


    if (
        !datePicker ||
        !currentDay ||
        !currentDate
    ) {
        return;
    }


    const selectedDate =
        new Date(
            datePicker.value + 'T00:00:00'
        );


    const hari = [
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    ];


    const bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];


    currentDay.textContent =
        hari[selectedDate.getDay()];


    currentDate.textContent =
        selectedDate.getDate()
        + ' '
        + bulan[selectedDate.getMonth()]
        + ' '
        + selectedDate.getFullYear();
}


/* =========================================================
   JAM REALTIME
========================================================= */

function updateDashboardTime() {

    const currentTime =
        document.getElementById('currentTime');

    if (!currentTime) {
        return;
    }


    const now = new Date();


    const jam =
        String(now.getHours()).padStart(2, '0');

    const menit =
        String(now.getMinutes()).padStart(2, '0');

    const detik =
        String(now.getSeconds()).padStart(2, '0');


    currentTime.textContent =
        `${jam}:${menit}:${detik}`;
}


/* =========================================================
   JALANKAN
========================================================= */

updateDashboardDate();

updateDashboardTime();


/* =========================================================
   UPDATE JAM SETIAP DETIK
========================================================= */

setInterval(
    updateDashboardTime,
    1000
);

/* =========================================================
   BUKA DATE PICKER
========================================================= */

function openDashboardDatePicker() {

    const datePicker =
        document.getElementById('dashboardDatePicker');

    if (!datePicker) {
        return;
    }

    if (typeof datePicker.showPicker === 'function') {

        datePicker.showPicker();

    } else {

        datePicker.focus();

    }
}


/* =========================================================
   DATE PICKER
========================================================= */

const dashboardDatePicker =
    document.getElementById('dashboardDatePicker');


if (dashboardDatePicker) {

    dashboardDatePicker.addEventListener(
        'change',
        function () {

            const tanggal =
                this.value;


            if (!tanggal) {
                return;
            }


            window.location.href =
                `/admin/dashboard?tanggal=${tanggal}`;

        }
    );

}

</script>

@endsection