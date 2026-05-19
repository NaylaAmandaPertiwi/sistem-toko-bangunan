<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Barang</title>

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

/* FILTER */
.filter-box{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.filter-left{
    display:flex;
    gap:10px;
}

.filter-left input{
    padding:10px;
    width:250px;
    border:1px solid #ccc;
    border-radius:8px;
}

.filter-left select{
    padding:10px;
    border:1px solid #ccc;
    border-radius:8px;
}

.add-btn{
    background:#4e73df;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:8px;
    cursor:pointer;
}

.add-btn:hover{
    background:#375ad3;
}

/* TABLE */
.table-box{
    background:white;
    padding:20px;
    border-radius:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f1f3f6;
    padding:15px;
    text-align:left;
}

table td{
    padding:15px;
    border-bottom:1px solid #ddd;
}

.edit-btn{
    background:#ffc107;
    border:none;
    padding:8px 10px;
    border-radius:6px;
    cursor:pointer;
    color:white;
}

.delete-btn{
    background:#dc3545;
    border:none;
    padding:8px 10px;
    border-radius:6px;
    cursor:pointer;
    color:white;
}

.edit-btn:hover{
    background:#e0a800;
}

.delete-btn:hover{
    background:#bb2d3b;
}

.action{
    display:flex;
    gap:8px;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        Nayla Bangunan
    </div>

    <a href="/dashboard">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>

    <a href="/data-barang "class="active">
        <i class="fa-solid fa-box"></i>
        Data Barang
    </a>

    <a href="#">
        <i class="fa-solid fa-layer-group"></i>
        Kategori Barang
    </a>

    <a href="#">
        <i class="fa-solid fa-warehouse"></i>
        Stok Barang
    </a>

    <a href="#">
        <i class="fa-solid fa-users"></i>
        Data Pengguna
    </a>

    <a href="#">
        <i class="fa-solid fa-percent"></i>
        Diskon
    </a>

    <a href="#">
        <i class="fa-solid fa-chart-line"></i>
        Laporan Keuangan
    </a>

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

        <h2>Data Barang</h2>

        <form method="POST" action="/logout">
            @csrf

            <button class="logout">
                Logout
            </button>
        </form>

    </div>


    <!-- FILTER -->
    <div class="filter-box">

        <div class="filter-left">

            <input type="text"
                   placeholder="Cari Nama Barang...">

            <select>
                <option>Semua Kategori</option>
                <option>Material</option>
                <option>Cat</option>
                <option>Besi</option>
            </select>

        </div>

        <button class="add-btn">
            <i class="fa-solid fa-plus"></i>
            Tambah Data Barang
        </button>

    </div>

    <!-- TABLE -->
    <div class="table-box">

        <table>

            <thead>

                <tr>

                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach($products as $product)

                <tr>

                    <td>
                        {{ $product['kode'] }}
                    </td>

                    <td>
                        {{ $product['nama'] }}
                    </td>

                    <td>
                        {{ $product['kategori'] }}
                    </td>

                    <td>
                        Rp {{ number_format($product['harga'],0,',','.') }}
                    </td>

                    <td>
                        {{ $product['stok'] }}
                    </td>

                    <td>

                        <div class="action">

                            <button class="edit-btn">

                                <i class="fa-solid fa-pen"></i>

                            </button>

                            <button class="delete-btn">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</body>
</html>