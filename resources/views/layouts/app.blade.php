<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>@yield('title')</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI', sans-serif;
    background:#f5f7fb;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    height:100vh;

    background:linear-gradient(180deg,#4e73df,#355cc9);

    position:fixed;
    left:0;
    top:0;

    padding:20px;

    color:white;

    overflow:hidden;
}

.sidebar-menu{
    height:calc(100vh - 140px);

    overflow-y:auto;

    padding-bottom:30px;
}

.sidebar-menu::-webkit-scrollbar{
    width:5px;
}

.sidebar-menu::-webkit-scrollbar-thumb{
    background:rgba(255,255,255,0.3);
    border-radius:10px;
}

.logo{
    font-size:24px;
    font-weight:700;
    margin-bottom:30px;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 14px;
    color:white;
    text-decoration:none;
    border-radius:10px;
    margin-bottom:6px;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.15);
}

.active{
    background:rgba(255,255,255,0.16);

    color:white !important;

    border-radius:10px;

    font-weight:600;

    backdrop-filter:blur(8px);
}

.dropdown-menu{
    margin-bottom:8px;
}

.dropdown-btn{
    width:100%;
    border:none;
    background:none;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 14px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
}

.dropdown-btn:hover{
    background:rgba(255,255,255,0.15);
}

.menu-left{
    display:flex;
    align-items:center;
    gap:12px;
}

.dropdown-content{
    display:none;
    margin-top:6px;
    margin-left:15px;
    border-left:2px solid rgba(255,255,255,0.2);
    padding-left:10px;
}

.dropdown-content a{
    padding:10px 12px;
    font-size:14px;
}

/* SUBMENU ACTIVE */
.dropdown-content a.submenu-active{
    background:rgba(255,255,255,0.18);

    border-radius:8px;

    color:white;

    font-weight:600;
}

.dropdown-content.show{
    display:block;
}

.produk-arrow,
.inventory-arrow,
.transaction-arrow,
.laporan-arrow{
    transition:0.3s;
}

.rotate{
    transform:rotate(180deg);
}

/* PROFILE */
.profile{
    position:absolute;

    bottom:20px;
    left:20px;
    right:20px;

    background:rgba(255,255,255,0.12);

    padding:14px;
    border-radius:14px;

    display:flex;
    align-items:center;
    gap:12px;

    backdrop-filter:blur(10px);

    z-index:999;
}

.profile i{
    font-size:30px;
}

.profile-text{
    line-height:1.4;
    font-size:14px;
}

/* CONTENT */
.content{
    margin-left:260px;
    padding:30px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.header h2{
    font-size:28px;
    font-weight:700;
    color:#2d3748;
}

/* BUTTON */
.logout{
    background:#dc3545;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.card{
    background:white;
    padding:22px;
    border-radius:16px;
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
}

.card h3{
    font-size:14px;
    color:#777;
    margin-bottom:12px;
}

.card p{
    font-size:26px;
    font-weight:700;
    color:#355cc9;
}

/* ROW */
.row{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
    margin-bottom:25px;
}

.box{
    background:white;
    padding:22px;
    border-radius:16px;
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th{
    background:#f3f5fa;
    padding:14px;
    text-align:left;
}

table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.status{
    background:#28a745;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}

</style>

@yield('styles')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
</head>


<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        Nayla Bangunan
    </div>
    <div class="sidebar-menu">

    
    <!-- DASHBOARD -->

    <a href="/dashboard"
    class="{{ request()->is('dashboard*') ? 'active' : '' }}">


    <i class="fa-solid fa-house"></i>
    Dashboard

    </a>

    <!-- PRODUK -->

    <div class="dropdown-menu">

    <button class="dropdown-btn"
            onclick="toggleProdukDropdown()">

        <div class="menu-left">

            <i class="fa-solid fa-box"></i>
            Produk

        </div>

        <i class="fa-solid fa-chevron-down produk-arrow"></i>

    </button>

    <div class="dropdown-content
    {{ request()->is('produk*') ||
    request()->is('kategori-produk*') ||
    request()->is('barcode*')
    ? 'show' : '' }}"
    id="produkDropdown">

        <a href="/produk"
        class="{{ request()->is('produk*') ? 'submenu-active' : '' }}">
            Produk
        </a>

        <a href="/kategori-produk"
        class="{{ request()->is('kategori-produk*') ? 'submenu-active' : '' }}">
            Kategori
        </a>

        <a href="/barcode"
        class="{{ request()->is('barcode*') ? 'submenu-active' : '' }}">
            Barcode
        </a>

    </div>

    </div>

    <!-- SUPPLIER -->

    <a href="/supplier"
    class="{{ request()->is('supplier*') ? 'active' : '' }}">

    <i class="fa-solid fa-truck"></i>
    Supplier

    </a>

    <!-- INVENTORY -->

    <div class="dropdown-menu">


    <button class="dropdown-btn"
            onclick="toggleInventoryDropdown()">

        <div class="menu-left">

            <i class="fa-solid fa-warehouse"></i>
            Inventory

        </div>

        <i class="fa-solid fa-chevron-down inventory-arrow"></i>

    </button>

    <div class="dropdown-content
    {{ request()->is('stok-masuk*') ||
    request()->is('stok-opname*') ||
    request()->is('pergerakan-stok*') ||
    request()->is('peringatan-stok*')
    ? 'show' : '' }}"
    id="inventoryDropdown">

        <a href="/stok-masuk"
        class="{{ request()->is('stok-masuk*') ? 'submenu-active' : '' }}">
            Stok Masuk
        </a>

        <a href="/stok-opname"
        class="{{ request()->is('stok-opname*') ? 'submenu-active' : '' }}">
            Stok Opname
        </a>

        <a href="/pergerakan-stok"
        class="{{ request()->is('pergerakan-stok*') ? 'submenu-active' : '' }}">
            Pergerakan Stok
        </a>

        <a href="/peringatan-stok"
        class="{{ request()->is('peringatan-stok*') ? 'submenu-active' : '' }}">
            Peringatan Stok
        </a>

    </div>

    </div>

    <!-- TRANSAKSI -->

    <div class="dropdown-menu">

    <button class="dropdown-btn"
            onclick="toggleTransactionDropdown()">

        <div class="menu-left">

            <i class="fa-solid fa-cart-shopping"></i>
            Transaksi

        </div>

        <i class="fa-solid fa-chevron-down transaction-arrow"></i>

    </button>

    <div class="dropdown-content
    {{ request()->is('penjualan*') ||
    request()->is('retur*') ||
    request()->is('riwayat*')
    ? 'show' : '' }}"
    id="transactionDropdown">

        <a href="/penjualan"
        class="{{ request()->is('penjualan*') ? 'submenu-active' : '' }}">
            Penjualan
        </a>

        <a href="/retur"
        class="{{ request()->is('retur*') ? 'submenu-active' : '' }}">
            Retur
        </a>

        <a href="/riwayat-transaksi"
        class="{{ request()->is('riwayat-transaksi*') ? 'submenu-active' : '' }}">
            Riwayat
        </a>

    </div>

    </div>

    <!-- DISKON -->

    <a href="/diskon"
    class="{{ request()->is('diskon*') ? 'active' : '' }}">

    <i class="fa-solid fa-percent"></i>
    Diskon

    </a>

    <!-- LAPORAN -->

    <div class="dropdown-menu">

    <button class="dropdown-btn"
            onclick="toggleLaporanDropdown()">

        <div class="menu-left">

            <i class="fa-solid fa-chart-column"></i>
            Laporan

        </div>

        <i class="fa-solid fa-chevron-down laporan-arrow"></i>

    </button>

    <div class="dropdown-content
    {{ request()->is('laporan*')
    ? 'show' : '' }}"
    id="laporanDropdown">

        <a href="/laporan-penjualan"
        class="{{ request()->is('laporan-penjualan*') ? 'submenu-active' : '' }}">
            Penjualan
        </a>

        <a href="/laporan-stok"
        class="{{ request()->is('laporan-stok*') ? 'submenu-active' : '' }}">
            Stok
        </a>

        <a href="/laporan-barang-terlaris"
        class="{{ request()->is('laporan-barang-terlaris*') ? 'submenu-active' : '' }}">
            Barang Terlaris
        </a>

        <a href="/laporan-keuangan"
        class="{{ request()->is('laporan-keuangan*') ? 'submenu-active' : '' }}">
            Keuangan
        </a>

    </div>

    </div>


    <!-- PROFILE -->
    <div class="profile">

        <i class="fa-solid fa-circle-user"></i>

        <div class="profile-text">

            <b>Nayla Amanda</b><br>
            Owner Toko

        </div>

    </div>

</div>

<!-- CONTENT -->
<div class="content">

    @yield('content')

</div>

<script>


/* DROPDOWN TRANSAKSI */
function toggleTransactionDropdown() {

    const dropdown =
        document.getElementById('transactionDropdown');

    const arrow =
        document.querySelector('.transaction-arrow');

    dropdown.classList.toggle('show');

    arrow.classList.toggle('rotate');
}


/* DROPDOWN LAPORAN */
function toggleLaporanDropdown() {

    const dropdown =
        document.getElementById('laporanDropdown');

    const arrow =
        document.querySelector('.laporan-arrow');

    dropdown.classList.toggle('show');

    arrow.classList.toggle('rotate');
}

function toggleProdukDropdown() {

    document
    .getElementById('produkDropdown')
    .classList.toggle('show');

    document
    .querySelector('.produk-arrow')
    .classList.toggle('rotate');
}

function toggleInventoryDropdown() {

    document
    .getElementById('inventoryDropdown')
    .classList.toggle('show');

    document
    .querySelector('.inventory-arrow')
    .classList.toggle('rotate');
}

window.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.dropdown-content.show')
    .forEach(function(dropdown){

        const arrow = dropdown.parentElement
            .querySelector('i.fa-chevron-down');

        if(arrow){
            arrow.classList.add('rotate');
        }

    });

});

</script>

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

@yield('scripts')

</body>
</html>