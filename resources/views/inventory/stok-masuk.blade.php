@extends('layouts.app')

@section('title', 'Stok Masuk')

@section('content')

<style>

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
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
    text-decoration:none;
    padding:18px;
    color:#444;
    font-weight:600;
}

.tab-active{
    color:#1e293b;
    background:linear-gradient(
        to top,
        rgba(22,132,224,.12),
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
    flex-wrap:wrap;
    gap:15px;
}

.left-filter{
    display:flex;
    gap:10px;
}

.right-filter{
    display:flex;
    gap:10px;
}

.filter-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.search-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.btn{
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    color:white;
}

.btn-primary{
    background:#1684e0;
}

.btn-success{
    background:#4CAF50;
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
    color:#999;
    padding:40px;
}

</style>

<div class="page-header">

    <div class="top-header">
        Inventory
    </div>

    <div class="tab-menu">

        <a href="/stok-masuk"
           class="tab-active">
            Stok Masuk
        </a>

        <a href="/stok-keluar">
            Stok Keluar
        </a>

        <a href="/stok-opname">
            Stok Opname
        </a>

        <a href="/pergerakan-stok">
            Pergerakan Stok
        </a>

        <a href="/peringatan-stok">
            Peringatan Stok
        </a>

    </div>

    <div class="filter-section">

        <div class="left-filter">

            <select class="filter-box">
                <option>10 Baris</option>
                <option>25 Baris</option>
                <option>50 Baris</option>
            </select>

        </div>

        <div class="right-filter">

            <input
                type="date"
                class="filter-box">

            <input
                type="date"
                class="filter-box">

            <button class="btn btn-primary">
                Export
            </button>

            <button class="btn btn-success">
                Tambah
            </button>

            <input
                type="text"
                class="search-box"
                placeholder="Cari Transaksi">

        </div>

    </div>

    <div class="table-section">

        <table>

            <thead>

                <tr>

                    <th>No Transaksi</th>

                    <th>Supplier</th>

                    <th>Tanggal Masuk</th>

                    <th>Barang</th>

                    <th>Jumlah Masuk</th>

                    <th>Harga Beli</th>

                    <th>Total</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td colspan="7"
                        class="no-data">

                        Belum ada data stok masuk

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection