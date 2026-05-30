@extends('layouts.app')

@section('title', 'Kategori Produk')

@section('content')

<style>

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* HEADER */
.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

/* TAB */
.tab-menu{
    display:flex;
    border-bottom:1px solid #eee;
}

.tab-menu a{
    flex:1;
    text-align:center;
    padding:18px;
    text-decoration:none;
    color:#444;
    font-weight:600;
}

.tab-active{
    color:#1e293b;

    background:linear-gradient(
        to top,
        rgba(22,132,224,0.12),
        transparent
    );

    border-bottom:3px solid #1684e0;
}

/* FILTER */
.filter-section{
    padding:25px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    gap:15px;
}

.search-box{
    flex:1;
}

.search-box input{
    width:100%;
    padding:12px 15px;
    border:1px solid #ddd;
    border-radius:10px;
}

.add-btn{
    background:#4CAF50;
    color:white;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
}

/* TABLE */
.table-section{
    padding:25px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f3f5fa;
    padding:15px;
    text-align:left;
}

table td{
    padding:15px;
    border-bottom:1px solid #eee;
}

.no-data{
    text-align:center;
    padding:50px;
    color:#999;
}

</style>

<div class="page-header">

    <!-- HEADER -->
    <div class="top-header">
        Katalog Produk
    </div>

    <!-- TAB -->
    <div class="tab-menu">

        <a href="/produk">
            Produk
        </a>

        <a href="/kategori-produk"
           class="tab-active">
            Kategori Produk
        </a>

    </div>

    <!-- FILTER -->
    <div class="filter-section">

        <div class="search-box">

            <input
                type="text"
                placeholder="Cari Kategori Produk">

        </div>

        <button class="add-btn">

            <i class="fa-solid fa-plus"></i>
            Tambah Kategori

        </button>

    </div>

    <!-- TABLE -->
    <div class="table-section">

        <table>

            <thead>

                <tr>

                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td colspan="4"
                        class="no-data">

                        Belum ada kategori produk

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection