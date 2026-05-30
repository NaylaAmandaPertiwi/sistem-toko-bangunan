@extends('layouts.app')

@section('title', 'Produk')

@section('content')

<style>

/* HEADER */
.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* TOP HEADER */
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
    background:white;
    border-bottom:1px solid #eee;
}

.tab-menu a{
    flex:1;
    text-align:center;
    padding:18px;
    text-decoration:none;
    color:#444;
    font-weight:600;
    transition:0.3s;
}

.tab-menu a:hover{
    background:#f3f5fa;
}

.tab-menu .tab-active{

    color:#1e293b;

    background:linear-gradient(
        to top,
        rgba(22,132,224,0.12),
        transparent
    );

    border-bottom:3px solid #7093af;
}

.tab-menu a{
    position:relative;
}

.tab-menu .tab-active{
    font-weight:700;
}

/* FILTER */
.filter-section{
    padding:25px;
    display:flex;
    justify-content:space-between;
    gap:15px;
    flex-wrap:wrap;
}

.left-filter{
    display:flex;
    gap:15px;
}

.filter-box{
    background:white;
    border:1px solid #ddd;
    border-radius:10px;
    padding:12px 16px;
    min-width:200px;
    cursor:pointer;
}

.search-box{
    flex:1;
}

.search-box input{
    width:100%;
    padding:12px 16px;
    border:1px solid #ddd;
    border-radius:10px;
}

/* BUTTON */
.add-btn{
    background:#4CAF50;
    color:white;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
}

.add-btn:hover{
    background:#43a047;
}

/* TABLE */
.table-section{
    padding:25px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:12px;
    overflow:hidden;
}

table th{
    background:#f3f5fa;
    padding:16px;
    text-align:left;
}

table td{
    padding:16px;
    border-bottom:1px solid #eee;
}

.no-data{
    text-align:center;
    padding:40px;
    color:#999;
}

.table-wrapper{
    overflow-x:auto;
}

table{
    min-width:1200px;
}

thead th{
    white-space:nowrap;
}

th i{
    font-size:12px;
    margin-left:5px;
    color:#999;
}

.table-footer{
    margin-top:18px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    flex-wrap:wrap;

    gap:15px;
}

.footer-left,
.footer-right{
    display:flex;
    align-items:center;
    gap:14px;
}

.footer-left select{
    padding:8px 12px;
    border:1px solid #ddd;
    border-radius:8px;
}

.footer-right button{
    border:none;
    background:none;
    cursor:pointer;
    color:#666;
}

.footer-right input{
    width:60px;
    padding:8px;
    border:1px solid #ddd;
    border-radius:8px;
    text-align:center;
}

.page-active{
    color:#1684e0;
    font-weight:600;
}

.delete-btn{
    border:none;
    background:none;
    cursor:pointer;
    font-size:18px;
    color:#999;
}

.status-active{
    background:#d1fae5;
    color:#065f46;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

</style>




    <div class="page-header">

        <!-- HEADER -->
        <div class="top-header">

            Katalog Produk

        </div>

        <!-- TAB -->
        <div class="tab-menu">

            <a href="/produk"
               class="tab-active">

               Produk

            </a>

            <a href="">

               Kategori Produk

            </a>

        </div>

        <!-- FILTER -->
        <div class="filter-section">

            <div class="left-filter">

                <select class="filter-box">

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}">

                            {{ $category->nama_kategori }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="search-box">

                <input type="text"
                       placeholder="Cari Produk">

            </div>

            <button class="add-btn">

                <i class="fa-solid fa-plus"></i>
                Tambah Produk

            </button>

        </div>

        <!-- TABLE -->
        <div class="table-section">

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Nama Produk
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Kategori
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                SKU
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Barcode
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Qty Stok
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Satuan
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Harga Beli
                            </th>

                            <th>
                                Harga Jual
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td colspan="10"
                                class="no-data">

                                Belum ada produk

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

            <!-- FOOTER TABLE -->
            <div class="table-footer">

                <div class="footer-left">

                    <button class="delete-btn">

                        <i class="fa-regular fa-trash-can"></i>

                    </button>

                    <select>

                        <option>10/page</option>
                        <option>25/page</option>
                        <option>50/page</option>

                    </select>

                    <span>Total 0</span>

                </div>

                <div class="footer-right">

                    <button>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <span class="page-active">1</span>

                    <button>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <span>Go to</span>

                    <input type="number"
                        value="1">

                </div>

            </div>

        </div>

    </div>



@endsection