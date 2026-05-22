<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Owner</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;
    background:#f4f6f9;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    height:100vh;
    background:#4e73df;
    position:fixed;
    left:0;
    top:0;
    padding:20px;
    color:white;
}

.logo{
    font-size:24px;
    font-weight:bold;
    margin-bottom:30px;
}

.menu-title{
    font-size:13px;
    margin-bottom:10px;
    opacity:0.7;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px;
    color:white;
    text-decoration:none;
    border-radius:10px;
    margin-bottom:10px;
    transition:0.3s;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.15);
}

.sidebar .active{
    background:white;
    color:#4e73df;
    font-weight:bold;
}

/* DROPDOWN */
.dropdown-menu{
    margin-bottom:10px;
}

.dropdown-btn{
    width:100%;
    border:none;
    background:none;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px;
    border-radius:10px;
    cursor:pointer;
    font-size:16px;
    transition:0.3s;
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
    margin-top:8px;
    margin-left:15px;
    border-left:2px solid rgba(255,255,255,0.2);
    padding-left:10px;
}

.dropdown-content a{
    padding:12px;
    font-size:15px;
}

.dropdown-content.show{
    display:block;
}

.arrow{
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
    background:rgba(255,255,255,0.15);
    padding:15px;
    border-radius:12px;
    display:flex;
    align-items:center;
    gap:12px;
}

.profile i{
    font-size:30px;
}

.profile-text{
    font-size:14px;
}

/* CONTENT */
.content{
    margin-left:260px;
    padding:25px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.logout{
    background:#dc3545;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:8px;
    cursor:pointer;
}

.logout:hover{
    background:#bb2d3b;
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
    padding:20px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.card h3{
    font-size:15px;
    color:#666;
    margin-bottom:10px;
}

.card p{
    font-size:22px;
    font-weight:bold;
    color:#4e73df;
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
    padding:20px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th{
    background:#f1f3f6;
    padding:14px;
    text-align:left;
}

table td{
    padding:14px;
    border-bottom:1px solid #ddd;
}

.status{
    background:#28a745;
    color:white;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        Nayla Bangunan
    </div>

    <a href="/dashboard" class="active">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>

    <!-- DROPDOWN PRODUK & INVENTORY -->
<div class="dropdown-menu">

    <button class="dropdown-btn" onclick="toggleDropdown()">
        <div class="menu-left">
            <i class="fa-solid fa-boxes-stacked"></i>
            Produk & Inventory
        </div>

        <i class="fa-solid fa-chevron-down arrow"></i>
    </button>

    <div class="dropdown-content" id="inventoryDropdown">

        <a href="/produk">
            <i class="fa-solid fa-box"></i>
            Produk
        </a>

        <a href="/inventory">
            <i class="fa-solid fa-warehouse"></i>
            Inventory
        </a>

        <a href="/barcode">
            <i class="fa-solid fa-barcode"></i>
            Cetak Barcode Produk
        </a>

        <a href="/label-harga">
            <i class="fa-solid fa-tag"></i>
            Cetak Label Harga
        </a>

    </div>

</div>

<!-- DROPDOWN TRANSAKSI -->
<div class="dropdown-menu">

    <button class="dropdown-btn" onclick="toggleTransactionDropdown()">

        <div class="menu-left">

            <i class="fa-solid fa-cart-shopping"></i>
            Transaksi

        </div>

        <i class="fa-solid fa-chevron-down transaction-arrow"></i>

    </button>

    <div class="dropdown-content" id="transactionDropdown">

        <a href="/penjualan">

            <i class="fa-solid fa-cash-register"></i>
            Penjualan

        </a>

        <a href="/pembayaran">

            <i class="fa-solid fa-credit-card"></i>
            Pembayaran

        </a>

        <a href="/retur-barang">

            <i class="fa-solid fa-rotate-left"></i>
            Retur Barang

        </a>

        <a href="/riwayat-transaksi">

            <i class="fa-solid fa-clock-rotate-left"></i>
            Riwayat Transaksi

        </a>

    </div>

</div>

<!-- DROPDOWN PEGAWAI -->
<div class="dropdown-menu">

    <button class="dropdown-btn"
            onclick="togglePegawaiDropdown()">

        <div class="menu-left">

            <i class="fa-solid fa-user-group"></i>
            Pegawai

        </div>

        <i class="fa-solid fa-chevron-down pegawai-arrow"></i>

    </button>

    <div class="dropdown-content"
         id="pegawaiDropdown">

        <a href="/staff">

            <i class="fa-solid fa-user"></i>
            Staff

        </a>

        <a href="/kehadiran">

            <i class="fa-solid fa-calendar-check"></i>
            Kehadiran

        </a>

    </div>

</div>


    <a href="#">
        <i class="fa-solid fa-percent"></i>
        Diskon
    </a>

    <!-- DROPDOWN LAPORAN -->
<div class="dropdown-menu">

    <button class="dropdown-btn"
            onclick="toggleLaporanDropdown()">

        <div class="menu-left">

            <i class="fa-solid fa-chart-column"></i>
            Laporan & Pembukuan

        </div>

        <i class="fa-solid fa-chevron-down laporan-arrow"></i>

    </button>

    <div class="dropdown-content"
         id="laporanDropdown">

        <a href="/laporan-penjualan">

            <i class="fa-solid fa-chart-line"></i>
            Laporan Penjualan

        </a>

        <a href="/laporan-stok">

            <i class="fa-solid fa-boxes-stacked"></i>
            Laporan Stok

        </a>

        <a href="/laporan-barang-masuk">

            <i class="fa-solid fa-arrow-right-to-bracket"></i>
            Laporan Barang Masuk

        </a>

        <a href="/laporan-barang-keluar">

            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            Laporan Barang Keluar

        </a>

        <a href="/laporan-keuangan">

            <i class="fa-solid fa-wallet"></i>
            Laporan Keuangan

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

    <!-- HEADER -->
    <div class="header">

        <h2>Dashboard Owner</h2>

        <form method="POST" action="/logout">
            @csrf

            <button class="logout">
                Logout
            </button>

        </form>

    </div>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Jumlah Transaksi</h3>
            <p>{{ $data['total_transaksi'] }}</p>
        </div>

        <div class="card">
            <h3>Stok Menipis</h3>
            <p>{{ $data['stok_menipis'] }}</p>
        </div>

        <div class="card">
            <h3>Total Penjualan</h3>
            <p>Rp {{ number_format($data['total_penjualan'],0,',','.') }}</p>
        </div>

        <div class="card">
            <h3>Diskon Aktif</h3>
            <p>{{ $data['diskon_aktif'] }}</p>
        </div>

    </div>

    <!-- ROW -->
    <div class="row">

        <div class="box">
            <h3>Grafik Penjualan</h3>
            <br>
            <p>Grafik penjualan nanti bisa menggunakan Chart.js</p>
        </div>

        <div class="box">
            <h3>Peringatan Stok</h3>
            <br>
            <p>Beberapa barang hampir habis.</p>
        </div>

    </div>

    <!-- TABLE -->
    <div class="box">

        <h3>Transaksi Terakhir</h3>

        <table>

            <tr>
                <th>ID</th>
                <th>Waktu</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>#TRX-94821</td>
                <td>14:23</td>
                <td>Budi</td>
                <td>Rp 156.000</td>
                <td>
                    <span class="status">
                        SUKSES
                    </span>
                </td>
            </tr>

        </table>

    </div>

</div>

<script>

/* DROPDOWN PRODUK & INVENTORY */
function toggleDropdown() {

    const dropdown =
        document.getElementById('inventoryDropdown');

    const arrow =
        document.querySelector('.arrow');

    dropdown.classList.toggle('show');

    arrow.classList.toggle('rotate');
}

/* DROPDOWN TRANSAKSI */
function toggleTransactionDropdown() {

    const dropdown =
        document.getElementById('transactionDropdown');

    const arrow =
        document.querySelector('.transaction-arrow');

    dropdown.classList.toggle('show');

    arrow.classList.toggle('rotate');
}

/* DROPDOWN PEGAWAI */
function togglePegawaiDropdown() {

    const dropdown =
        document.getElementById('pegawaiDropdown');

    const arrow =
        document.querySelector('.pegawai-arrow');

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

</script>

</body>
</html>