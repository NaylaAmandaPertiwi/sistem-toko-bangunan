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

.profile > .fa-circle-user{
    font-size:30px;
}

.profile-text{
    line-height:1.4;
    font-size:14px;
}

.profile-arrow{
    margin-left:auto;
    font-size:11px;
    transition:.3s;
}

.profile-arrow.rotate{
    transform:rotate(180deg);
}

.profile{
    cursor:pointer;
}

.profile-menu{

    position:absolute;

    left:20px;
    right:20px;

    bottom:95px;

    background:#fff;

    border-radius:14px;

    overflow:hidden;

    display:none;

    box-shadow:0 8px 25px rgba(0,0,0,.15);

    z-index:9999;
}

.profile-menu.show{
    display:block;
}

.profile-menu a{

    display:flex;
    align-items:center;
    gap:12px;

    padding:15px 18px;

    color:#444;

    text-decoration:none;

    transition:.2s;
}

.profile-menu a:hover{
    background:#f5f7fb;
}

.profile-menu button{

    width:100%;

    border:none;

    background:#fff5f5;

    color:#dc3545;

    padding:15px 18px;

    text-align:left;

    cursor:pointer;

    display:flex;
    align-items:center;
    gap:12px;

    font-size:14px;
}

.profile-menu button:hover{
    background:#ffe9e9;
}

.menu-divider{
    height:1px;
    background:#eaeaea;
}

.profile{
    cursor:pointer;
}

.profile-menu{

    position:absolute;

    left:20px;
    right:20px;

    bottom:95px;

    background:white;

    border-radius:15px;

    overflow:hidden;

    display:none;

    box-shadow:0 5px 20px rgba(0,0,0,.15);

    z-index:9999;
}

.profile-menu.show{
    display:block;
}

.profile-menu a{
    color:#333;
    padding:16px;
    display:flex;
    align-items:center;
    gap:10px;
    text-decoration:none;
}

.profile-menu button{

    width:100%;

    border:none;

    background:#fff3f3;

    color:#dc3545;

    text-align:left;

    padding:16px;

    cursor:pointer;

    display:flex;
    align-items:center;
    gap:10px;

    font-size:14px;
}

/* CONTENT */
.content{
    margin-left:260px;
    padding:30px;
}

/* Prevent accidental page scaling and keep content responsive */
.content{
    max-width: calc(100% - 260px);
    box-sizing: border-box;
    transform: none !important;
    -webkit-transform: none !important;
    zoom: 1;
    overflow-x: hidden;
}

@media (max-width: 900px){
    .content{
        margin-left:0;
        padding:20px;
    }
    .sidebar{
        position:fixed;
        transform:translateX(-100%);
    }
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

.dashboard-summary{

    display:grid;

    grid-template-columns:
    repeat(3,1fr);

    gap:20px;

    margin-bottom:25px;
}

.summary-item{

    background:white;

    padding:25px;

    border-radius:16px;

    box-shadow:
    0 4px 12px rgba(0,0,0,.05);
}

.summary-item span{

    color:#777;

    font-size:14px;
}

.summary-item h3{

    margin-top:10px;

    color:#355cc9;

    font-size:26px;
}

.filter-box{

    background:white;

    padding:10px 18px;

    border-radius:10px;

    box-shadow:
    0 2px 8px rgba(0,0,0,.05);
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

/* =====================================================
   GLOBAL TOAST NOTIFICATION
===================================================== */

.toast{

    position:fixed;

    top:25px;
    left:50%;

    transform:translateX(-50%);

    display:flex;
    align-items:center;
    gap:12px;

    padding:14px 22px;

    min-width:280px;
    max-width:420px;

    border-radius:50px;

    color:white;

    font-size:15px;
    font-weight:500;

    backdrop-filter:blur(10px);

    box-shadow:0 10px 25px rgba(0,0,0,.15);

    z-index:999999;

    animation:toastShow .35s ease;
}

.toast i{

    font-size:20px;

}

/* Warna */

.toast-success{

    background:rgba(40,167,69,.95);

}

.toast-error{

    background:rgba(220,53,69,.95);

}

.toast-warning{

    background:rgba(255,193,7,.95);

    color:#333;

}

.toast-info{

    background:rgba(22,132,224,.95);

}

@keyframes toastShow{

    from{

        opacity:0;

        transform:
        translate(-50%,-25px);

    }

    to{

        opacity:1;

        transform:
        translate(-50%,0);

    }

}

.toast-hide{

    animation:toastHide .35s forwards;

}

@keyframes toastHide{

    from{

        opacity:1;

        transform:
        translate(-50%,0);

    }

    to{

        opacity:0;

        transform:
        translate(-50%,-20px);

    }

}

/* ==========================
   GLOBAL CONFIRM MODAL
========================== */

.confirm-overlay{

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.45);

    display:none;

    justify-content:center;

    align-items:center;

    z-index:999999;

}

.confirm-overlay.show{

    display:flex;

}

.confirm-box{

    width:420px;

    background:white;

    border-radius:18px;

    padding:30px;

    text-align:center;

    animation:popup .25s ease;

}

.confirm-icon{

    width:75px;

    height:75px;

    margin:auto;

    margin-bottom:20px;

    border-radius:50%;

    background:#fff3cd;

    color:#f39c12;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:34px;

}

.confirm-title{

    font-size:22px;

    font-weight:700;

    margin-bottom:10px;

}

.confirm-text{

    color:#666;

    margin-bottom:25px;

    line-height:1.6;

}

.confirm-actions{

    display:flex;

    justify-content:center;

    gap:15px;

}

.btn-confirm{

    background:#dc3545;

    color:white;

    border:none;

    padding:12px 25px;

    border-radius:10px;

    cursor:pointer;

}

.btn-cancel-modal{

    background:#e9ecef;

    color:#333;

    border:none;

    padding:12px 25px;

    border-radius:10px;

    cursor:pointer;

}

@keyframes popup{

    from{

        opacity:0;

        transform:scale(.9);

    }

    to{

        opacity:1;

        transform:scale(1);

    }

}

</style>

@yield('styles')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<link
href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
rel="stylesheet">

</head>


<body>

@if(session('success'))

<div id="globalToast" class="toast toast-success">

    <i class="fa-solid fa-circle-check"></i>

    <span>

        {{ session('success') }}

    </span>

</div>

@endif


@if(session('error'))

<div id="globalToast" class="toast toast-error">

    <i class="fa-solid fa-circle-xmark"></i>

    <span>

        {{ session('error') }}

    </span>

</div>

@endif


@if(session('warning'))

<div id="globalToast" class="toast toast-warning">

    <i class="fa-solid fa-triangle-exclamation"></i>

    <span>

        {{ session('warning') }}

    </span>

</div>

@endif


@if(session('info'))

<div id="globalToast" class="toast toast-info">

    <i class="fa-solid fa-circle-info"></i>

    <span>

        {{ session('info') }}

    </span>

</div>

@endif

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        Nayla Bangunan
    </div>
    <div class="sidebar-menu">

    
    <!-- DASHBOARD -->

   <a href="{{ route('admin.dashboard') }}"
    class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">

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

    <div class="dropdown-content"
    id="produkDropdown">


        <a href="{{ route('admin.produk.index') }}"
        class="{{ request()->is('admin/produk*') ? 'submenu-active' : '' }}">
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

    <a href="{{ route('admin.supplier.index') }}"
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

    <div class="dropdown-content"
    id="inventoryDropdown">

        <a href="{{ route('admin.stok-masuk.index') }}"
        class="{{ request()->is('admin/stok-masuk*') ? 'submenu-active' : '' }}">
            Stok Masuk
        </a>

        <a href="{{ route('admin.stok-opname.index') }}"
        class="{{ request()->is('admin/stok-opname*') ? 'submenu-active' : '' }}">
            Stok Opname
        </a>

        <a href="{{ route('admin.stock-movement.index') }}"
        class="{{ request()->is('admin/stock-movement*') ? 'submenu-active' : '' }}">
            Pergerakan Stok
        </a>

        <a href="{{ route('admin.stock-alert.index') }}"
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

    <div class="dropdown-content"
    id="transactionDropdown">

        <a href="/penjualan"
        class="{{ request()->is('penjualan*') ? 'submenu-active' : '' }}">
            Data Penjualan
        </a>

        <a href="/retur"
        class="{{ request()->is('retur*') ? 'submenu-active' : '' }}">
            Retur Penjualan
        </a>

        <a href="/riwayat-transaksi"
        class="{{ request()->is('riwayat-transaksi*') ? 'submenu-active' : '' }}">
            Riwayat Transaksi
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

    <div class="dropdown-content"
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
</div>

    <!-- PROFILE -->
    <div class="profile"
        onclick="toggleProfileMenu()">

        <i class="fa-solid fa-circle-user"></i>

        <div class="profile-text">

            <b>Nayla Amanda</b><br>
            Owner Toko

        </div>

        <i class="fa-solid fa-chevron-up profile-arrow"></i>

    </div>

    <!-- DROP UP PROFILE -->
    <div id="profileMenu"
        class="profile-menu">

        <a href="/profil">

            <i class="fa-regular fa-user"></i>
            Profil Saya

        </a>

        <a href="/pengaturan-akun">

            <i class="fa-solid fa-gear"></i>
            Pengaturan Akun

        </a>

        <a href="/ubah-password">

            <i class="fa-solid fa-lock"></i>
            Ubah Password

        </a>

        <div class="menu-divider"></div>

        <form method="POST"
            action="/logout">
            @csrf

            <button type="submit">

                <i class="fa-solid fa-right-from-bracket"></i>
                Keluar

            </button>

        </form>

    </div>

</div>

<div id="confirmModal" class="confirm-overlay">

    <div class="confirm-box">

        <div class="confirm-icon">

            <i class="fa-solid fa-triangle-exclamation"></i>

        </div>

        <div
            id="confirmTitle"
            class="confirm-title">

            Konfirmasi

        </div>

        <div
            id="confirmText"
            class="confirm-text">

            Apakah Anda yakin?

        </div>

        <div class="confirm-actions">

            <button
                type="button"
                class="btn-cancel-modal"
                onclick="closeConfirm()">

                Batal

            </button>

            <button
                type="button"
                id="confirmButton"
                class="btn-confirm">

                Ya

            </button>

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

    localStorage.setItem(
        'transactionDropdown',
        dropdown.classList.contains('show')
    );
}


/* DROPDOWN LAPORAN */
function toggleLaporanDropdown() {

    const dropdown =
        document.getElementById('laporanDropdown');

    const arrow =
        document.querySelector('.laporan-arrow');

    dropdown.classList.toggle('show');
    arrow.classList.toggle('rotate');

    localStorage.setItem(
        'laporanDropdown',
        dropdown.classList.contains('show')
    );
}

function toggleProdukDropdown() {

    const dropdown =
        document.getElementById('produkDropdown');

    const arrow =
        document.querySelector('.produk-arrow');

    dropdown.classList.toggle('show');
    arrow.classList.toggle('rotate');

    localStorage.setItem(
        'produkDropdown',
        dropdown.classList.contains('show')
    );
}

function toggleInventoryDropdown() {

    const dropdown =
        document.getElementById('inventoryDropdown');

    const arrow =
        document.querySelector('.inventory-arrow');

    dropdown.classList.toggle('show');
    arrow.classList.toggle('rotate');

    localStorage.setItem(
        'inventoryDropdown',
        dropdown.classList.contains('show')
    );
}

window.addEventListener('DOMContentLoaded', () => {

    const dropdowns = [
        {
            id:'produkDropdown',
            arrow:'.produk-arrow',
            key:'produkDropdown'
        },
        {
            id:'inventoryDropdown',
            arrow:'.inventory-arrow',
            key:'inventoryDropdown'
        },
        {
            id:'transactionDropdown',
            arrow:'.transaction-arrow',
            key:'transactionDropdown'
        },
        {
            id:'laporanDropdown',
            arrow:'.laporan-arrow',
            key:'laporanDropdown'
        }
    ];

    dropdowns.forEach(item => {

        if(localStorage.getItem(item.key) === 'true')
        {
            document
            .getElementById(item.id)
            ?.classList.add('show');

            document
            .querySelector(item.arrow)
            ?.classList.add('rotate');
        }

    });

});

function toggleProfileMenu() {

    document
    .getElementById('profileMenu')
    .classList.toggle('show');

    document
    .querySelector('.profile-arrow')
    .classList.toggle('rotate');
}

</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@yield('scripts')

<script>

const toast =
document.getElementById('globalToast');

if(toast){

    setTimeout(function(){

        toast.classList.add('toast-hide');

        setTimeout(function(){

            toast.remove();

        },350);

    },3000);

}

let confirmCallback = null;

function showConfirm(
    title,
    message,
    callback
){

    document
    .getElementById('confirmTitle')
    .innerText = title;

    document
    .getElementById('confirmText')
    .innerText = message;

    document
    .getElementById('confirmModal')
    .classList.add('show');

    confirmCallback = callback;

}

function closeConfirm(){

    document
    .getElementById('confirmModal')
    .classList.remove('show');

}

document
.getElementById('confirmButton')
.addEventListener('click',function(){

    closeConfirm();

    if(confirmCallback){

        confirmCallback();

    }

});

</script>

</body>