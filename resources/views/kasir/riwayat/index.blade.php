@extends('layouts.kasir')

@section('title','Riwayat Transaksi')

@section('styles')

<style>

/* ===========================
   HEADER
=========================== */

.page-title{

    font-size:30px;

    font-weight:700;

    color:#2d3748;

    margin-bottom:6px;

}

.page-subtitle{

    color:#777;

    margin-bottom:25px;

}

/* ===========================
   TAB
=========================== */

.history-tabs{

    display:flex;

    gap:12px;

    margin-bottom:20px;

}

.history-tab{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:10px;

    padding:12px 22px;

    border:none;

    border-radius:12px;

    background:#edf2f7;

    color:#555;

    cursor:pointer;

    font-size:15px;

    font-weight:600;

    transition:.25s;

}

.history-tab:hover{

    background:#dbe6ff;

}

.history-tab.active{

    background:#355cc9;

    color:white;

}

.history-badge{

    display:inline-flex;

    justify-content:center;

    align-items:center;

    min-width:24px;

    height:24px;

    padding:0 8px;

    border-radius:20px;

    background:white;

    color:#355cc9;

    font-size:12px;

    font-weight:700;

    transition:.25s;

}

.history-tab.active .history-badge{

    background:rgba(255,255,255,.25);

    color:white;

}

/* ===========================
   CONTENT
=========================== */

.history-content{

    display:none;

}

.history-content.active{

    display:block;

}

.empty-data{

    text-align:center;

    padding:60px 20px;

    color:#999;

    font-size:15px;

}

/* ===========================
   TABLE STYLE
=========================== */

.box h3{

    font-size:20px;

    font-weight:700;

    color:#2d3748;

    margin-bottom:20px;

}

table thead th{

    background:#f3f5fa;

    color:#2d3748 !important;

    font-size:15px;

    font-weight:700;

    padding:16px;

    border-bottom:2px solid #e9ecef;

}

table tbody td{

    color:#444;

    padding:16px;

    vertical-align:middle;

}

.empty-data{

    color:#999 !important;

    font-weight:500;

    text-align:center;

}

.btn-detail{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    background:#355cc9;

    color:white;

    border:none;

    padding:7px 14px;

    border-radius:8px;

    cursor:pointer;

    font-size:12px;

    font-weight:600;

    min-width:78px;

    transition:.25s;

}

.btn-detail i{

    font-size:12px;

}

.btn-detail:hover{

    background:#2748a8;

    transform:translateY(-1px);

    box-shadow:0 4px 10px rgba(53,92,201,.25);

}

/* ===========================
   HISTORY TABLE
=========================== */

.history-table{

    width:100%;

    table-layout:fixed;

}

.history-table th,
.history-table td{

    vertical-align:middle;

}

.col-kode{

    width:30%;

}

.col-tanggal{

    width:20%;

}

.col-kasir{

    width:15%;

}

.col-total{

    width:20%;

}

.col-aksi{

    width:12%;

}

.action-column{

    text-align:center;

}

</style>

@endsection

@section('content')

<div class="header">

    <div>

        <h2 class="page-title">

            Riwayat Transaksi

        </h2>

        <div class="page-subtitle">

            Daftar seluruh transaksi penjualan dan retur.

        </div>

    </div>

</div>

<div class="history-tabs">

    <button
        class="history-tab active"
        id="btnPenjualan">

        <span>

            Riwayat Penjualan

        </span>

        <span class="history-badge">

            {{ $sales->total() }}

        </span>

    </button>

    <button
        class="history-tab"
        id="btnRetur">

        <span>

            Riwayat Retur

        </span>

        <span class="history-badge">

            {{ $returnSales->total() }}

        </span>

    </button>

</div>

{{-- ========================= --}}
{{-- PENJUALAN --}}
{{-- ========================= --}}

<div
    id="panelPenjualan"
    class="history-content active">

    <div class="box">

        <h3>

            Riwayat Penjualan

        </h3>

        <table class="history-table">

            <thead>

            <tr>

                <th class="col-kode">
                    Kode Transaksi
                </th>

                <th class="col-tanggal">
                    Tanggal
                </th>

                <th class="col-kasir">
                    Kasir
                </th>

                <th class="col-total">
                    Total Transaksi
                </th>

                <th class="col-aksi action-column">
                    Aksi
                </th>

            </tr>

            </thead>

            <tbody>

            @if($sales->count())

                @foreach($sales as $sale)

                <tr>

                    <td>

                        {{ $sale->kode_penjualan }}

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}

                    </td>

                    <td>

                        {{ $sale->user->name ?? '-' }}

                    </td>

                    <td>

                        Rp {{ number_format($sale->total_bayar,0,',','.') }}

                    </td>

                    <td class="action-column">

                        <button
                            class="btn-detail">

                            <i class="fa-solid fa-eye"></i>

                            Detail

                        </button>

                    </td>

                </tr>

                @endforeach

            @else

                <tr>

                    <td
                        colspan="5"
                        class="empty-data">

                        Belum ada data penjualan.

                    </td>

                </tr>

            @endif

            </tbody>

        </table>

    </div>

</div>

{{-- ========================= --}}
{{-- RETUR --}}
{{-- ========================= --}}

<div
    id="panelRetur"
    class="history-content">

    <div class="box">

        <h3>

            Riwayat Retur

        </h3>

        <table class="history-table">

            <thead>

            <tr>

                <th class="col-kode">
                    Kode Retur
                </th>

                <th class="col-tanggal">
                    Tanggal
                </th>

                <th class="col-kasir">
                    Kasir
                </th>

                <th class="col-total">
                    Total Retur
                </th>

                <th class="col-aksi action-column">
                    Aksi
                </th>

            </tr>

            </thead>

            <tbody>

            @if($returnSales->count())

                @foreach($returnSales as $return)

                <tr>

                    <td>

                        {{ $return->kode_retur }}

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($return->tanggal)->format('d/m/Y') }}

                    </td>

                    <td>

                        {{ $return->user->name ?? '-' }}

                    </td>

                    <td>

                        Rp {{ number_format($return->total_retur,0,',','.') }}

                    </td>

                    <td class="action-column">

                        <button
                            class="btn-detail">

                            <i class="fa-solid fa-eye"></i>

                            Detail

                        </button>

                    </td>

                </tr>

                @endforeach

            @else

                <tr>

                    <td
                        colspan="5"
                        class="empty-data">

                        Belum ada data retur.

                    </td>

                </tr>

            @endif

            </tbody>

        </table>

    </div>

</div>

@endsection

@section('scripts')

<script>

const btnPenjualan =
document.getElementById('btnPenjualan');

const btnRetur =
document.getElementById('btnRetur');

const panelPenjualan =
document.getElementById('panelPenjualan');

const panelRetur =
document.getElementById('panelRetur');

btnPenjualan.onclick = function(){

    btnPenjualan.classList.add('active');

    btnRetur.classList.remove('active');

    panelPenjualan.classList.add('active');

    panelRetur.classList.remove('active');

}

btnRetur.onclick = function(){

    btnRetur.classList.add('active');

    btnPenjualan.classList.remove('active');

    panelRetur.classList.add('active');

    panelPenjualan.classList.remove('active');

}

</script>

@endsection