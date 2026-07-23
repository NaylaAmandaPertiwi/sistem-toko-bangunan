@extends('layouts.kasir')

@section('title','Dashboard Kasir')

@section('styles')

<style>

.page-title{
    font-size:28px;
    font-weight:700;
    color:#2d3748;
    margin-bottom:6px;
}

.page-description{
    color:#6b7280;
    margin-bottom:30px;
}

.dashboard-card{
    background:#fff;
    border-radius:18px;
    padding:24px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
    transition:.25s;
    height:100%;
}

.dashboard-card:hover{
    transform:translateY(-4px);
}

.dashboard-icon{
    width:60px;
    height:60px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    color:#fff;
    margin-bottom:20px;
}

.icon-sales{
    background:#355cc9;
}

.icon-return{
    background:#f59e0b;
}

.icon-money{
    background:#10b981;
}

.icon-product{
    background:#8b5cf6;
}

.card-title{
    color:#6b7280;
    font-size:15px;
    margin-bottom:8px;
}

.card-value{
    font-size:30px;
    font-weight:700;
    color:#2d3748;
}

.card-footer{
    margin-top:12px;
    color:#9ca3af;
    font-size:14px;
}

.top-product-item{

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:15px 0;

    border-bottom:1px solid #edf2f7;

}

.top-product-item:last-child{

    border-bottom:none;

}

.ranking{

    width:42px;

    height:42px;

    background:#355cc9;

    color:#fff;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-weight:bold;

    margin-right:15px;

}

</style>

@endsection

@section('content')

<div class="container-fluid">

    <h2 class="page-title">
        Dashboard Kasir
    </h2>

    <p class="page-description">
        Ringkasan aktivitas kasir hari ini.
    </p>

    <div class="row g-4">

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="dashboard-icon icon-sales">

                    <i class="bi bi-cart-check"></i>

                </div>

                <div class="card-title">

                    Penjualan Hari Ini

                </div>

                <div class="card-value">

                    {{ number_format($salesToday) }}

                </div>

                <div class="card-footer">

                    Transaksi

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="dashboard-icon icon-return">

                    <i class="bi bi-arrow-counterclockwise"></i>

                </div>

                <div class="card-title">

                    Retur Hari Ini

                </div>

                <div class="card-value">

                    {{ number_format($returnsToday) }}

                </div>

                <div class="card-footer">

                    Retur

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="dashboard-icon icon-money">

                    <i class="bi bi-cash-stack"></i>

                </div>

                <div class="card-title">

                    Omzet Hari Ini

                </div>

                <div class="card-value">

                    Rp {{ number_format($revenueToday,0,',','.') }}

                </div>

                <div class="card-footer">

                    Total Penjualan

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="dashboard-card">

                <div class="dashboard-icon icon-product">

                    <i class="bi bi-box-seam"></i>

                </div>

                <div class="card-title">

                    Barang Terjual

                </div>

                <div class="card-value">

                    {{ number_format($productsSoldToday) }}

                </div>

                <div class="card-footer">

                    Item

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        {{-- Grafik Penjualan --}}
        <div class="col-lg-8">

            <div class="dashboard-card">

                <h5 class="mb-4">

                    Grafik Penjualan 7 Hari Terakhir

                </h5>

                <canvas id="salesChart" height="100"></canvas>

            </div>

        </div>

        {{-- Top Produk --}}
        <div class="col-lg-4">

            <div class="dashboard-card">

                <h5 class="mb-4">

                    Top 5 Produk Terlaris

                </h5>

                @forelse($topProducts as $index => $product)

                    <div class="top-product-item">

                        <div class="d-flex align-items-center">

                            <div class="ranking">

                                {{ $index + 1 }}

                            </div>

                            <div>

                                <div class="fw-bold">

                                    {{ $product->product->nama_produk }}

                                </div>

                                <small class="text-muted">

                                    {{ number_format($product->total_terjual) }} Item Terjual

                                </small>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="text-center text-muted">

                        Belum ada data penjualan.

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const salesData = @json($weeklySales);

const labels = salesData.map(item => item.tanggal);

const totals = salesData.map(item => item.total);

new Chart(

    document.getElementById("salesChart"),

    {

        type: "line",

        data: {

            labels: labels,

            datasets: [

                {

                    label: "Penjualan",

                    data: totals,

                    borderColor: "#355cc9",

                    backgroundColor: "rgba(53,92,201,.15)",

                    fill: true,

                    tension: .4

                }

            ]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    display: false

                }

            },

            scales: {

                y: {

                    beginAtZero: true

                }

            }

        }

    }

);

</script>

@endsection