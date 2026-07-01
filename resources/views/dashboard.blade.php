<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Owner</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #f4f6f9;
}

/* SIDEBAR */
.sidebar {
    width: 240px;
    height: 100vh;
    background: #4e73df;
    color: white;
    position: fixed;
    padding: 20px;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar a {
    display: block;
    padding: 10px;
    color: white;
    text-decoration: none;
    border-radius: 8px;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.2);
}

/* CONTENT */
.content {
    margin-left: 260px;
    padding: 20px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logout {
    background: #6c757d;
    color: white;
    padding: 8px 12px;
    border-radius: 8px;
    border: none;
}

/* CARDS */
.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-top: 20px;
}

.card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    border: 2px solid #4e73df;
}

/* ROW */
.row {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 15px;
    margin-top: 20px;
}

.box {
    background: white;
    padding: 15px;
    border-radius: 10px;
}

/* TABLE */
table {
    width: 100%;
    margin-top: 15px;
}

.status {
    background: green;
    color: white;
    padding: 3px 8px;
    border-radius: 6px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Nayla Bangunan</h2>

    <a class="active">Dashboard</a>
    <a>Data Barang</a>
    <a>Kategori Barang</a>
    <a>Stok Barang</a>
    <a>Data Pengguna</a>
    <a>Diskon</a>
    <a>Laporan Keuangan</a>
</div>

<!-- CONTENT -->
<div class="content">

    <!-- HEADER -->
    <div class="header">
        <h2>Dashboard Owner</h2>

        <form method="POST" action="/logout">
            @csrf
            <button class="logout">Logout</button>
        </form>
    </div>

    <!-- CARDS -->
    <div class="cards">
        <div class="card">
            <b>Jumlah Transaksi</b><br>
            {{ $data['total_transaksi'] }} Transaksi
        </div>

        <div class="card">
            <b>Stok Menipis</b><br>
            {{ $data['stok_menipis'] }} Barang
        </div>

        <div class="card">
            <b>Total Penjualan</b><br>
            Rp. {{ number_format($data['total_penjualan'],0,',','.') }}
        </div>

        <div class="card">
            <b>Diskon Aktif</b><br>
            {{ $data['diskon_aktif'] }} Diskon
        </div>
    </div>

    <!-- GRAFIK + PERINGATAN -->
    <div class="row">
        <div class="box">
            <h4>Grafik Penjualan</h4>
            <p>(Nanti pakai Chart.js)</p>
        </div>

        <div class="box">
            <h4>Peringatan Stok</h4>
            <p>Barang hampir habis...</p>
        </div>
    </div>

    <!-- TRANSAKSI -->
    <div class="box">
        <h4>Transaksi Terakhir</h4>

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
                <td>Rp. 156.000</td>
                <td><span class="status">SUKSES</span></td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>