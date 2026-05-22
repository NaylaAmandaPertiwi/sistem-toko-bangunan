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
    font-family:'Segoe UI', sans-serif;
    background:#f5f7fb;
    color:#333;
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
    overflow-y:auto;
    box-shadow:4px 0 15px rgba(0,0,0,0.08);
}

.logo{
    font-size:24px;
    font-weight:700;
    margin-bottom:30px;
    letter-spacing:0.5px;
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
    transition:0.3s;
    font-size:15px;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.15);
    transform:translateX(3px);
}

.sidebar .active{
    background:white;
    color:#355cc9;
    font-weight:600;
}

.sidebar a i{
    width:20px;
    text-align:center;
    font-size:16px;
}

/* DROPDOWN */
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
    margin-top:6px;
    margin-left:15px;
    border-left:2px solid rgba(255,255,255,0.2);
    padding-left:10px;
}

.dropdown-content a{
    padding:10px 12px;
    font-size:14px;
}

.dropdown-content.show{
    display:block;
}

.arrow,
.transaction-arrow,
.pegawai-arrow,
.laporan-arrow{
    transition:0.3s;
}

.rotate{
    transform:rotate(180deg);
}

/* PROFILE */
.profile{
    margin-top:30px;
    background:rgba(255,255,255,0.12);
    padding:14px;
    border-radius:14px;
    display:flex;
    align-items:center;
    gap:12px;
}

.profile i{
    font-size:32px;
}

.profile-text{
    font-size:13px;
    line-height:1.5;
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

.header p{
    font-size:14px;
    color:#888;
    margin-top:4px;
}

.logout{
    background:#dc3545;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
    font-size:14px;
    transition:0.3s;
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
    padding:22px;
    border-radius:16px;
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
    border-left:5px solid #4e73df;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-3px);
}

.card h3{
    font-size:14px;
    color:#777;
    margin-bottom:12px;
    font-weight:600;
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

.box h3{
    font-size:18px;
    margin-bottom:10px;
    color:#333;
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
    font-size:14px;
    color:#555;
}

table td{
    padding:14px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.status{
    background:#28a745;
    color:white;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
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
        Produk
    </a>

    <a href="/inventory">
        Inventory
    </a>

    <a href="/barcode">
        Cetak Barcode Produk
    </a>

    <a href="/label-harga">
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
            Penjualan
        </a>

        <a href="/pembayaran">
            Pembayaran
        </a>

        <a href="/retur-barang">
            Retur Barang
        </a>

        <a href="/riwayat-transaksi">
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
            Staff
        </a>

        <a href="/kehadiran">
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
            Laporan

        </div>

        <i class="fa-solid fa-chevron-down laporan-arrow"></i>

    </button>

    <div class="dropdown-content"
         id="laporanDropdown">

        <a href="/laporan-penjualan">
            Laporan Penjualan

        </a>

        <a href="/laporan-stok">
            Laporan Stok
        </a>

        <a href="/laporan-barang-masuk">
            Laporan Barang Masuk
        </a>

        <a href="/laporan-barang-keluar">
            Laporan Barang Keluar
        </a>

        <a href="/laporan-keuangan">
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