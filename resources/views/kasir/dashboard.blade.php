@extends('layouts.kasir')

@section('title','Dashboard Kasir')

@section('styles')

<style>

/* ==========================================================
   HERO HEADER
========================================================== */

.hero-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:30px;
}

.hero-left{

    flex:1;

}

.hero-right{

    display:flex;

    gap:20px;

    align-items:flex-start;

    position:relative;

    z-index:100;

}

.hero-title{

    font-size:28px;
    font-weight:700;
    color:#2d3748;
    margin-bottom:8px;

}

.hero-subtitle{

    font-size:16px;
    color:#6b7280;

}

.hero-subtitle strong{

    color:#2563eb;

}

/* ==========================================================
   HERO WIDGET
========================================================== */

.header-widget{

    background:#fff;

    border-radius:22px;

    padding:22px;

    display:flex;

    align-items:center;

    gap:16px;

    box-shadow:0 12px 30px rgba(0,0,0,.06);

    transition:.3s;

}

.header-widget:hover{

    transform:translateY(-3px);

    box-shadow:0 16px 40px rgba(37,99,235,.12);

}

/* Ukuran masing-masing widget */

.notification-widget{

    width:180px;

    height:90px;

    position:relative;

    flex-shrink:0;

}

.calendar-widget{

    width:200px;

    height:80px;

}

.live-widget{

    width:180px;

    height:80px;

}

.widget-icon{

    width:44px;

    height:44px;

    border-radius:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:24px;

    background:#edf4ff;

    color:#3563ff;

    position:relative;

}

.notification-count{

    position:absolute;

    top:-4px;

    right:-4px;

    min-width:22px;

    height:22px;

    padding:0 6px;

    border-radius:999px;

    background:#ef4444;

    color:#fff;

    font-size:11px;

    font-weight:700;

    display:flex;

    align-items:center;

    justify-content:center;

    box-shadow:0 3px 8px rgba(239,68,68,.3);

}

.widget-title{

    font-size:14px;

    font-weight:600;

    color:#374151;

}

.widget-content{

    line-height:1.4;

}

.notification-widget{

    position:relative;

    cursor:pointer;

    display:flex;

    align-items:center;

    overflow:visible;

}

.notification-dropdown{

    position:absolute;

    top:calc(100% + 14px);

    left:50%;

    transform:translateX(-50%);

    width:360px;

    background:#ffffff;

    border-radius:22px;

    overflow:hidden;

    box-shadow:0 18px 40px rgba(0,0,0,.15);

    z-index:9999;

    opacity:0;

    visibility:hidden;

    transition:.25s;

}

.notification-dropdown.show{

    opacity:1;

    visibility:visible;

}

.notification-dropdown.show{

    display:block;

}

.notification-dropdown::before{

    content:"";

    position:absolute;

    top:-8px;

    right:120px;

    width:16px;

    height:16px;

    background:white;

    transform:rotate(45deg);

    border-left:1px solid #edf2f7;

    border-top:1px solid #edf2f7;

}

.notification-header{

    background:#355cc9;

    color:#ffffff;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:18px 22px;

}

.notification-title{

    display:flex;

    align-items:center;

    gap:10px;

    font-weight:600;

    color:#ffffff;

}

.notification-total{

    background:rgba(255,255,255,.18);

    color:#ffffff;

    padding:6px 14px;

    border-radius:999px;

    font-size:13px;

    font-weight:600;

}

.notification-body{

    max-height:340px;

    overflow-y:auto;

}

.notification-body::-webkit-scrollbar{

    width:6px;

}

.notification-body::-webkit-scrollbar-thumb{

    background:#fff;

    border-radius:20px;

}

.notification-item{

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:18px 20px;

    border-bottom:1px solid #f1f5f9;

    transition:.25s;

    cursor:pointer;

}

.notification-left{

    display:flex;

    align-items:center;

    gap:15px;

}

.notification-item:last-child{

    border-bottom:none;

}

.notification-item:hover{

    background:#f8fbff;

}

.notification-item-icon{

    width:42px;

    height:42px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#f3f4f6;

    font-size:20px;

}

.notification-product{

    font-weight:600;

    color:#2d3748;

    font-size:14px;

}

.notification-stock{

    margin-top:3px;

    font-size:13px;

    color:#6b7280;

}

.notification-empty{

    padding:30px;

    text-align:center;

    color:#6b7280;

    display:flex;

    flex-direction:column;

    gap:10px;

    align-items:center;

    justify-content:center;

}

.notification-empty i{

    font-size:36px;

}

.widget-subtitle{

    display:block;
    margin-top:3px;

    font-size:13px;

    color:#6b7280;

}

.header-live-time{

    font-size:22px;

    font-weight:700;

    color:#2563eb;

}

.header-live-badge{

    display:inline-block;

    margin-top:8px;

    background:#dcfce7;

    color:#16a34a;

    padding:6px 14px;

    border-radius:999px;

    font-size:12px;

    font-weight:700;

}

/* ==========================================================
   STATISTIC CARD
========================================================== */

.stats-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:20px;

    margin-bottom:30px;

}

.stats-card{

    background:#fff;

    border-radius:18px;

    padding:20px;

    min-height:150px;

    box-shadow:0 8px 25px rgba(0,0,0,.06);

    border:1px solid #edf2f7;

    transition:.3s;

}

.stats-card:hover{

    transform:translateY(-6px);

    box-shadow:0 18px 40px rgba(53,92,201,.15);

}

.stats-icon{

    width:58px;
    height:58px;

    display:flex;
    align-items:center;
    justify-content:center;

    border-radius:16px;

    font-size:24px;

    color:white;

    margin-bottom:18px;

}

.stats-title{

    color:#6b7280;

    font-size:14px;

    margin-bottom:8px;

}

.stats-value{

    font-size:28px;

    font-weight:700;

    color:#1f2937;

    margin-bottom:5px;

}

.stats-subtitle{

    color:#9ca3af;

    font-size:13px;

}

.bg-sales{

    background:#355cc9;

}

.bg-money{

    background:#10b981;

}

.bg-return{

    background:#f59e0b;

}

.bg-product{

    background:#8b5cf6;

}

/* ==========================================================
   DASHBOARD CARD
========================================================== */

.dashboard-card{

    background:#ffffff;

    border-radius:22px;

    padding:25px;

    box-shadow:0 12px 30px rgba(0,0,0,.06);

    border:1px solid #edf2f7;

    height:100%;
}

/* ==========================================================
   RESPONSIVE
========================================================== */

/* Laptop */

@media(max-width:1200px){

    .hero-header{

        flex-direction:column;
        align-items:flex-start;

    }

    .hero-right{

        width:100%;
        justify-content:flex-start;
        flex-wrap:wrap;

    }

    .stats-grid{

        grid-template-columns:repeat(2,1fr);

    }

}

/* Tablet */

@media(max-width:768px){

    .stats-grid{

        grid-template-columns:1fr;

    }

}

/* =====================================================
   TOP PRODUCT TABLE
===================================================== */

.top-product-table{

    margin-bottom:0;

}

.top-product-table thead th{

    border:none;

    font-size:13px;

    color:#6b7280;

    font-weight:600;

    padding-bottom:12px;

}

.top-product-table tbody td{

    border-top:1px solid #edf2f7;

    padding:14px 0;

    vertical-align:middle;

}

.top-product-table tbody tr:first-child td{

    border-top:none;

}

.rank-number{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    width:24px;

    height:24px;

    border-radius:50%;

    background:#355cc9;

    color:#fff;

    font-size:12px;

    font-weight:700;

}

.product-name{

    font-size:14px;

    font-weight:600;

    color:#2d3748;

}

.qty-badge{

    display:inline-block;

    min-width:48px;

    text-align:center;

    background:#edf4ff;

    color:#355cc9;

    padding:5px 10px;

    border-radius:30px;

    font-size:13px;

    font-weight:600;

}

/* ==========================================================
   DATE MODAL
========================================================== */

.date-modal-overlay{

    position:fixed;

    inset:0;

    background:rgba(15,23,42,.45);

    display:flex;

    align-items:center;

    justify-content:center;

    opacity:0;

    visibility:hidden;

    transition:.25s;

    z-index:5000;

}

.date-modal-overlay.show{

    opacity:1;

    visibility:visible;

}

.date-modal{

    width:420px;

    background:#ffffff;

    border-radius:24px;

    overflow:hidden;

    box-shadow:0 20px 60px rgba(0,0,0,.18);

    animation:modalScale .25s ease;

}

@keyframes modalScale{

    from{

        transform:scale(.92);

        opacity:0;

    }

    to{

        transform:scale(1);

        opacity:1;

    }

}

.date-modal-header{

    padding:20px 24px;

    background:#355cc9;

    color:#ffffff;

}

.date-modal-header h5{

    margin:0;

    font-size:18px;

    font-weight:700;

}

.date-modal-body{

    padding:28px 24px;

}

.date-input-wrapper{

    display:flex;

    flex-direction:column;

    gap:10px;

}

.date-label{

    font-size:14px;

    font-weight:600;

    color:#374151;

}

.date-input{

    width:100%;

    padding:12px 15px;

    border:1px solid #d1d5db;

    border-radius:12px;

    font-size:15px;

    outline:none;

    transition:.2s;

}

.date-input:focus{

    border-color:#355cc9;

    box-shadow:0 0 0 3px rgba(53,92,201,.15);

}

.date-modal-footer{

    display:flex;

    justify-content:flex-end;

    gap:12px;

    padding:20px 24px;

    border-top:1px solid #edf2f7;

}

.btn-date-cancel{

    border:none;

    background:#e5e7eb;

    color:#374151;

    padding:10px 18px;

    border-radius:12px;

    font-weight:600;

    cursor:pointer;

    transition:.2s;

}

.btn-date-cancel:hover{

    background:#d1d5db;

}

.btn-date-save{

    border:none;

    background:#355cc9;

    color:#ffffff;

    padding:10px 20px;

    border-radius:12px;

    font-weight:600;

    cursor:pointer;

    transition:.2s;

}

.btn-date-save:hover{

    background:#2748a5;

}

</style>

@endsection

@section('content')

<div class="container-fluid">

    {{-- ==========================================================
        HEADER DASHBOARD
    ========================================================== --}}

    <div class="hero-header">

        <div class="hero-left">

            <h1 class="hero-title">
                Dashboard Kasir
            </h1>

            <p class="hero-subtitle">
                Selamat datang kembali,
                <strong>{{ Auth::user()->name }}</strong> 👋
            </p>

        </div>

        <div class="hero-right">

            {{-- ===============================
                NOTIFIKASI STOK MINIMUM
            ================================ --}}
            <div class="header-widget notification-widget" id="notificationWidget">

                <div class="widget-icon notification">

                    <i class="bi bi-bell"></i>

                    @if($lowStockCount > 0)

                        <span class="notification-count">
                            {{ $lowStockCount }}
                        </span>

                    @endif

                </div>

                <div class="widget-content">

                    <div class="widget-title">
                        Notifikasi
                    </div>

                    <small class="widget-subtitle">

                        @if($lowStockCount > 0)

                            {{ $lowStockCount }} Barang Minimum

                        @else

                            Semua stok aman

                        @endif

                    </small>

                </div>

                {{-- Dropdown Notifikasi --}}
                <div class="notification-dropdown" id="notificationDropdown">

                    <div class="notification-header">

                        <div class="notification-title">

                            <i class="bi bi-bell-fill"></i>

                            Notifikasi Stok

                        </div>

                        <div class="notification-total">

                            {{ $lowStockCount }} Barang

                        </div>

                    </div>

                    <div class="notification-body">

                        @forelse($lowStockProducts as $product)

                            <div class="notification-item">

                                <div class="notification-left">

                                    <div class="notification-item-icon">

                                        @if($product->stok == 0)

                                            <i class="bi bi-x-octagon-fill text-danger"></i>

                                        @else

                                            <i class="bi bi-exclamation-circle-fill text-warning"></i>

                                        @endif

                                    </div>

                                    <div>

                                        <div class="notification-product">

                                            {{ $product->nama_produk }}

                                        </div>

                                        <div class="notification-stock">

                                            Stok

                                            <strong>{{ $product->stok }}</strong>

                                            • Minimum

                                            <strong>{{ $product->stok_minimum }}</strong>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="notification-empty">

                                <i class="bi bi-check-circle-fill text-success"></i>

                                <span>Semua stok masih aman.</span>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

            {{-- Tanggal --}}
            <div
                class="header-widget calendar-widget"
                id="calendarWidget">

                <div class="widget-icon calendar">

                    <i class="bi bi-calendar3"></i>

                </div>

                <div class="widget-content">

                    <div
                        class="widget-title"
                        id="calendarDay">

                        {{ $selectedDate->translatedFormat('l') }}

                    </div>

                    <small
                        id="calendarDate">

                        {{ $selectedDate->translatedFormat('d F Y') }}

                    </small>

                </div>

            </div>

            {{-- Jam --}}
            <div class="header-widget live-widget">

                <div class="widget-icon clock">

                    <i class="bi bi-clock"></i>

                </div>

                <div>

                    <div id="currentTime" class="header-live-time">

                    </div>

                    <span class="header-live-badge">

                        ● LIVE

                    </span>

                </div>

            </div>

        </div>

    </div>

    {{-- ==========================================================
        STATISTIC CARDS
    ========================================================== --}}

    <div class="stats-grid">

        {{-- Penjualan --}}
        <div class="stats-card">

            <div class="stats-icon bg-sales">

                <i class="bi bi-cart-check-fill"></i>

            </div>

            <div class="stats-title">

                Penjualan Hari Ini

            </div>

            <div
                class="stats-value"
                id="salesToday">

                {{ $salesToday }}

            </div>

            <div class="stats-subtitle">

                Transaksi

            </div>

        </div>

        {{-- Omzet --}}
        <div class="stats-card">

            <div class="stats-icon bg-money">

                <i class="bi bi-cash-stack"></i>

            </div>

            <div class="stats-title">

                Omzet Hari Ini

            </div>

            <div
                class="stats-value"
                id="revenueToday">

                Rp {{ number_format($revenueToday,0,',','.') }}

            </div>

            <div class="stats-subtitle">

                Total Penjualan

            </div>

        </div>

        {{-- Retur --}}
        <div class="stats-card">

            <div class="stats-icon bg-return">

                <i class="bi bi-arrow-counterclockwise"></i>

            </div>

            <div class="stats-title">

                Retur Hari Ini

            </div>

            <div
                class="stats-value"
                id="returnsToday">

                {{ $returnsToday }}

            </div>

            <div class="stats-subtitle">

                Retur

            </div>

        </div>

        {{-- Barang --}}
        <div class="stats-card">

            <div class="stats-icon bg-product">

                <i class="bi bi-box-seam-fill"></i>

            </div>

            <div class="stats-title">

                Barang Terjual

            </div>

            <div
                class="stats-value"
                id="productsSoldToday">

                {{ $productsSoldToday }}

            </div>

            <div class="stats-subtitle">

                Item Terjual

            </div>

        </div>

    </div>

    {{-- ==========================================================
        ANALYTICS
    ========================================================== --}}

    <div class="row g-4 mt-2">

        {{-- =========================
            SALES CHART
        ========================= --}}

        <div class="col-xl-8 col-lg-7">

            <div class="dashboard-card">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h3 id="chartTitle">

                        <i class="bi bi-graph-up-arrow"></i>

                        Penjualan
                        {{ $chartStartDate }}
                        –
                        {{ $chartEndDate }}

                    </h3>

                    <span class="badge bg-light text-primary">

                        Live Data

                    </span>

                </div>

                <canvas id="salesChart" height="100"></canvas>

            </div>

        </div>

        {{-- =========================
            TOP PRODUCTS
        ========================= --}}
        <div class="col-xl-4 col-lg-5">

            <div class="dashboard-card">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h5 class="fw-bold mb-0">

                        <i class="bi bi-trophy-fill text-warning me-2"></i>

                        Top 5 Produk

                    </h5>

                    <span class="badge bg-light text-warning">

                        Terlaris

                    </span>

                </div>

                <div class="table-responsive">

                    <table class="table table-borderless align-middle top-product-table">

                        <thead>

                            <tr>

                                <th width="40">#</th>

                                <th>Produk</th>

                                <th class="text-end">Qty</th>

                            </tr>

                        </thead>

                        <tbody id="topProductsBody">

                            @forelse($topProducts as $index => $product)

                                <tr>

                                    <td>

                                        <span class="rank-number">

                                            {{ $index + 1 }}

                                        </span>

                                    </td>

                                    <td>

                                        <div class="product-name">

                                            {{ $product->product->nama_produk }}

                                        </div>

                                    </td>

                                    <td class="text-end">

                                        <span class="qty-badge">

                                            {{ number_format($product->total_terjual) }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3" class="text-center text-muted py-4">

                                        Belum ada data.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- ==========================================================
     MODAL PILIH TANGGAL
========================================================== --}}

<div class="date-modal-overlay" id="dateModal">

    <div class="date-modal">

        <div class="date-modal-header">

            <h5>

                <i class="bi bi-calendar3"></i>

                Pilih Tanggal

            </h5>

        </div>

        <div class="date-modal-body">

            <div class="date-input-wrapper">

                <label class="date-label">

                    Pilih Tanggal Dashboard

                </label>

                <input
                    type="date"
                    id="dashboardDate"
                    class="date-input"
                    value="{{ request('date', now()->format('Y-m-d')) }}">

            </div>

        </div>

        <div class="date-modal-footer">

            <button
                type="button"
                class="btn-date-cancel"
                id="closeDateModal">

                Batal

            </button>

            <button
                type="button"
                class="btn-date-save"
                id="saveDate">

                Simpan

            </button>

        </div>

    </div>

</div>

@endsection

@section('scripts')

{{-- ==========================================================
     JAVASCRIPT
========================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// Sales Chart

const salesData = @json($weeklySales);

const labels = salesData.map(item => item.tanggal);

const totals = salesData.map(item => item.total);

const salesChart = new Chart(

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

// Clock

function updateClock(){

    const now = new Date();

    document.getElementById("currentTime").innerHTML =
        now.toLocaleTimeString("id-ID");

}

updateClock();

setInterval(updateClock,1000);

const notificationWidget =
    document.getElementById("notificationWidget");

const notificationDropdown =
    document.getElementById("notificationDropdown");

notificationWidget.addEventListener("click", function(e){

    e.stopPropagation();

    notificationDropdown.classList.toggle("show");

});

document.addEventListener("click", function(e){

    if(!notificationWidget.contains(e.target)){

        notificationDropdown.classList.remove("show");

    }

});

const dateModal =
    document.getElementById("dateModal");

const calendarWidget =
    document.getElementById("calendarWidget");

const closeDateModal =
    document.getElementById("closeDateModal");

calendarWidget.addEventListener("click", function(){

    dateModal.classList.add("show");

});

closeDateModal.addEventListener("click", function(){

    dateModal.classList.remove("show");

});

dateModal.addEventListener("click", function(e){

    if(e.target === dateModal){

        dateModal.classList.remove("show");

    }

});

function formatRupiah(number){

    return "Rp " + Number(number).toLocaleString("id-ID");

}

const saveDate =
    document.getElementById("saveDate");

saveDate.addEventListener("click", function(){

    const selectedDate =
        document.getElementById("dashboardDate").value;

    if(!selectedDate){

        alert("Silakan pilih tanggal terlebih dahulu.");

        return;

    }

    fetch(`/kasir/dashboard/data?date=${selectedDate}`)

        .then(response => response.json())

        .then(data => {

            console.log(data);

            dateModal.classList.remove("show");

            history.pushState(
                {},
                "",
                `/kasir/dashboard?date=${selectedDate}`
            );

            document.getElementById("salesToday").innerText =
                data.salesToday;

            document.getElementById("revenueToday").innerText =
                formatRupiah(data.revenueToday);

            document.getElementById("returnsToday").innerText =
                data.returnsToday;

            document.getElementById("productsSoldToday").innerText =
                data.productsSoldToday;

            salesChart.data.labels =
                data.weeklySales.map(item => item.tanggal);

            salesChart.data.datasets[0].data =
                data.weeklySales.map(item => item.total);

            salesChart.update();

            const topProductsBody =
                document.getElementById("topProductsBody");

            topProductsBody.innerHTML = "";

            if(data.topProducts.length === 0){

                topProductsBody.innerHTML = `

                    <tr>

                        <td colspan="3"
                            class="text-center text-muted py-4">

                            Belum ada data.

                        </td>

                    </tr>

                `;

            }else{

                data.topProducts.forEach((product,index)=>{

                    topProductsBody.innerHTML += `

                        <tr>

                            <td>

                                <span class="rank-number">

                                    ${index + 1}

                                </span>

                            </td>

                            <td>

                                <div class="product-name">

                                    ${product.product.nama_produk}

                                </div>

                            </td>

                            <td class="text-end">

                                <span class="qty-badge">

                                    ${Number(product.total_terjual)}

                                </span>

                            </td>

                        </tr>

                    `;

                });

            }

            document.getElementById("chartTitle").innerText =
                data.chartTitle;

        })

        .catch(error => {

            console.error(error);

        });

});

</script>

@endsection