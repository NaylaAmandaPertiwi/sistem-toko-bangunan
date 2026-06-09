@extends('layouts.app')

@section('title', 'Stok Keluar')

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

.filter-top{
    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:20px;
}

.stock-info h2{
    margin:0;
    font-size:18px;
}

.stock-info span{
    color:#999;
}

.toolbar{
    display:flex;
    align-items:center;
    gap:10px;
}

.filter-bottom{
    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.date-range{
    display:flex;
    align-items:center;
    gap:15px;

    padding:14px 18px;

    border:1px solid #ddd;
    border-radius:10px;

    background:white;

    cursor:pointer;

    border:none;
    outline:none;

    color:#333;

    font-size:14px;
}

.date-text{
    display:flex;
    align-items:center;
    gap:10px;

    font-weight:600;
}

.search-box{
    width:260px;

    padding:12px 15px;

    border:1px solid #ddd;
    border-radius:10px;
}

.btn-primary{
    background:#1684e0;
}

.btn-primary i{
    margin-right:8px;
}

.filter-box{
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

/* DATE RANGE PICKER */
.daterangepicker .ranges li{
    padding:10px 15px;
}

.daterangepicker .ranges li.active{
    background:#1684e0;
}

.daterangepicker td.active,
.daterangepicker td.active:hover{
    background:#1684e0;
}

.daterangepicker .applyBtn{
    background:#1684e0;
    border-color:#1684e0;
}

</style>

<div class="page-header">

    <div class="top-header">
        Inventory
    </div>

    <div class="tab-menu">

        <a href="/stok-masuk">
            Stok Masuk
        </a>

        <a href="/stok-keluar"
        class="tab-active">
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

        <div class="filter-top">

            <div class="stock-info">

                <h2>Daftar Stok Keluar</h2>

                <span>0 Stok Keluar</span>

            </div>

            <div class="toolbar">

                <button
                    type="button"
                    id="dateRangePicker"
                    class="date-range">

                    <i class="fa-solid fa-chevron-left"></i>

                    <div class="date-text">

                        <i class="fa-regular fa-calendar"></i>

                        <span id="selectedDate">
                            02 Jun 26 - 02 Jun 26
                        </span>

                        <i class="fa-solid fa-caret-down"></i>

                    </div>

                    <i class="fa-solid fa-chevron-right"></i>

                </button>

                <button class="btn btn-primary">
                    <i class="fa-solid fa-download"></i>
                    Export
                </button>

                <button class="btn btn-primary">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    Import
                </button>

                <a href="/stok-keluar/create"
                class="btn btn-primary">

                    <i class="fa-solid fa-plus"></i>
                    Tambah

                </a>

            </div>

        </div>

        <div class="filter-bottom">

            <select class="filter-box">

                <option>10 Baris</option>
                <option>25 Baris</option>
                <option>50 Baris</option>

            </select>

            <input
                type="text"
                class="search-box"
                placeholder="Cari No. Stok Keluar">

        </div>

    </div>

    <div class="table-section">

        <table>

            <thead>

                <tr>

                    <th>No Transaksi</th>

                    <th>Tanggal Keluar</th>

                    <th>Barang</th>

                    <th>Jumlah Keluar</th>

                    <th>Harga Jual</th>

                    <th>Total</th>

                    <th>Tujuan</th>

                    <th>Petugas</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td colspan="7"
                        class="no-data">

                        Belum ada data stok keluar

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection

@section('scripts')

<script>

$(function(){

    console.log('Date Range Loaded');

    $('#dateRangePicker').daterangepicker({

        startDate: moment(),

        endDate: moment(),

        autoUpdateInput: false,

        ranges: {

            'Today': [
                moment(),
                moment()
            ],

            'Yesterday': [
                moment().subtract(1,'days'),
                moment().subtract(1,'days')
            ],

            'Last 7 Days': [
                moment().subtract(6,'days'),
                moment()
            ],

            'Last 30 Days': [
                moment().subtract(29,'days'),
                moment()
            ],

            'This Month': [
                moment().startOf('month'),
                moment().endOf('month')
            ],

            'Last Month': [
                moment().subtract(1,'month').startOf('month'),
                moment().subtract(1,'month').endOf('month')
            ],

            'This Year': [
                moment().startOf('year'),
                moment().endOf('year')
            ],

            'Last Year': [
                moment().subtract(1,'year').startOf('year'),
                moment().subtract(1,'year').endOf('year')
            ]

        }

    },

    function(start,end){

        $('#selectedDate').text(
            start.format('DD MMM YY')
            + ' - ' +
            end.format('DD MMM YY')
        );

    });

});

</script>

@endsection