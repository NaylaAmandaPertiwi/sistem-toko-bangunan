@extends('layouts.kasir')

@section('styles')

<style>

.page-title{

    font-size:40px;

    font-weight:700;

    margin-bottom:30px;

}

.card-retur{

    background:#fff;

    border-radius:18px;

    padding:25px;

    box-shadow:0 10px 30px rgba(0,0,0,.06);

    margin-bottom:25px;

}

.card-title{

    font-size:20px;

    font-weight:700;

    margin-bottom:20px;

}

.form-control{

    height:48px;

    border-radius:12px;

}

.form-select{

    height:48px;

    border-radius:12px;

}

textarea{

    border-radius:12px !important;

}

.btn-primary{

    border-radius:12px;

    padding:10px 20px;

    font-weight:600;

}

.btn-success{

    border-radius:12px;

    padding:10px 20px;

}

.btn-danger{

    border-radius:12px;

}

.table{

    margin-bottom:0;

}

.table thead{

    background:#f5f7fb;

}

.table th{

    border:none;

    font-weight:700;

    padding:15px;

}

.table td{

    vertical-align:middle;

    padding:15px;

}

.summary-box{

    background:#f8fbff;

    border:1px solid #dbe9ff;

    border-radius:15px;

    padding:20px;

}

.summary-total{

    font-size:28px;

    font-weight:bold;

    color:#355cc9;

}

@media(max-width:768px){

    .card-retur{

        padding:15px;

    }

    .page-title{

        font-size:28px;

    }

}

</style>

@endsection

@section('title','Retur Barang')

@section('content')

<div class="container-fluid">

    <h2 class="page-title">

        Retur Barang

    </h2>

    <!-- Card Cari Transaksi -->

    ...

    <!-- Card Daftar Transaksi -->

    ...

    <!-- Card Detail Barang -->

    ...

    <!-- Card Ringkasan -->

    ...

</div>

@endsection