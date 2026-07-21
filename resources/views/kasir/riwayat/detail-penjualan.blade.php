@extends('layouts.kasir')

@section('title','Detail Penjualan')

@section('styles')

<style>

/* ===========================================================
   LAYOUT
=========================================================== */

.detail-container{

    max-width:1200px;

    margin:0 auto;

}

.page-header{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    margin-bottom:30px;

}

.page-header h1{

    font-size:28px;

    font-weight:700;

    color:#2d3748;

    margin:0;

}

.page-header p{

    margin-top:4px;

    color:#718096;

    font-size:15px;

}

.header-action{

    display:flex;

    gap:12px;

}

/* ===========================================================
   BUTTON
=========================================================== */

.btn-back,
.btn-print{

    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:12px 22px;

    border-radius:12px;

    text-decoration:none;

    font-weight:600;

    transition:.25s;

}

.btn-back{

    background:#edf2f7;

    color:#2d3748;

}

.btn-back:hover{

    background:#e2e8f0;

}

.btn-print{

    background:#355cc9;

    color:white;

    border:none;

    cursor:pointer;

}

.btn-print:hover{

    background:#2748a8;

}

/* ===========================================================
   CARD
=========================================================== */

.detail-card{

    background:white;

    border-radius:20px;

    padding:35px;

    box-shadow:0 8px 24px rgba(0,0,0,.05);

}

.transaction-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:30px;

}

.transaction-header h2{

    font-size:22px;

    font-weight:700;

    color:#2d3748;

    margin:0 0 6px;

}

.transaction-header span{

    font-size:15px;

    color:#718096;

}

.status-success{
    display:inline-flex;
    align-items:center;
    gap:7px;

    background:#dcfce7;
    color:#15803d;

    border:1px solid #bbf7d0;
    border-radius:999px;

    padding:8px 15px;

    font-size:13px;
    font-weight:700;

    white-space:nowrap;
}

.status-success i{
    display:flex;
    align-items:center;
    justify-content:center;

    width:18px;
    height:18px;

    background:#22c55e;
    color:#ffffff;

    border-radius:50%;

    font-size:10px;
}

/* ===========================================================
   INFO CARD
=========================================================== */

.information-grid,

.summary-grid{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:16px;

    margin-bottom:22px;

}

.info-card,
.summary-card{

    background:#f8fafc;

    border:1px solid #edf2f7;

    border-radius:14px;

    padding:16px 18px;

}

.info-card span,
.summary-card span{

    display:block;

    color:#718096;

    font-size:13px;

    margin-bottom:6px;

}

.info-card strong,
.summary-card strong{

    font-size:16px;

    font-weight:700;

    color:#2d3748;

}

.section-card{

    margin-top:35px;

}

.section-header{

    margin-bottom:18px;

}

.section-header h3{

    font-size:20px;

    font-weight:700;

    color:#2d3748;

}

.table-wrapper{

    overflow-x:auto;

}

.table-wrapper table{

    width:100%;

    border-collapse:collapse;

}

.table-wrapper thead{

    background:#edf2f7;

}

.table-wrapper th{

    color:#2d3748;

    font-weight:700;

    padding:18px;

    text-align:left;

}

.table-wrapper td{

    padding:18px;

    border-top:1px solid #edf2f7;

    color:#4a5568;

}

.table-wrapper tbody tr:hover{

    background:#f8fafc;

}

@media(max-width:992px){

    .information-grid,

    .summary-grid{

        grid-template-columns:repeat(2,1fr);

    }

}

@media(max-width:576px){

    .page-header{

        flex-direction:column;

        gap:20px;

    }

    .information-grid,

    .summary-grid{

        grid-template-columns:1fr;

    }

}

/* ======================================================
   PRINT INVOICE
====================================================== */

@media print{

    body{

        background:white !important;

    }

    .sidebar,
    .navbar,
    .page-header{

        display:none !important;

    }

    .content{

        margin:0 !important;

        padding:0 !important;

    }

    .detail-container{

        max-width:100%;

        margin:0;

        padding:0;

    }

    .invoice-card{

        box-shadow:none;

        border:none;

        padding:0;

    }

    .invoice-title{

        color:#000;

        font-size:28px;

        margin-bottom:8px;

    }

    .invoice-information{

        display:block;

        margin-bottom:25px;

    }

    .info-item{

        background:none;

        padding:0;

        margin-bottom:8px;

        border:none;

    }

    .info-item span{

        display:inline-block;

        width:150px;

        color:#000;

        font-weight:600;

    }

    .info-item strong{

        color:#000;

        font-weight:normal;

    }

    .table-wrapper table{

        width:100%;

        border-collapse:collapse;

    }

    .table-wrapper table th{

        background:#000 !important;

        color:#fff !important;

    }

    .table-wrapper table th,
    .table-wrapper table td{

        border:1px solid #000;

        padding:8px;

    }

    .payment-card{

        width:320px;

        margin-left:auto;

        margin-top:25px;

    }

    .payment-card table td{

        border:none;

        padding:6px 0;

    }

    .invoice-footer{

        margin-top:40px;

        border-top:1px dashed #000;

        padding-top:15px;

        color:#000;

    }

}

.store-header{

    display:none;

}

@media print{

.store-header{

    display:block;

    text-align:center;

    margin-bottom:25px;

}

.store-header h2{

    margin:0;

    font-size:28px;

}

.store-header p{

    margin:3px 0;

}

}

</style>

@endsection

@section('content')

<div class="detail-container">

    {{-- Header Halaman --}}
    <div class="page-header">

        <div>

            <h1>Detail Penjualan</h1>

            <p>
                Informasi lengkap transaksi penjualan.
            </p>

        </div>

        <div class="header-action">

            <a
                href="{{ route('kasir.riwayat.index') }}"
                class="btn-back">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

            <button
                class="btn-print"
                onclick="window.print()">

                <i class="fa-solid fa-print"></i>

                Cetak

            </button>

        </div>

    </div>

    {{-- Card Utama --}}
    <div class="detail-card">

        {{-- Judul Transaksi --}}
        <div class="transaction-header">

            <div>

                <h2>Transaksi Penjualan</h2>

                <span>

                    {{ $sale->kode_penjualan }}

                </span>

            </div>

            <div class="status-success">

                Selesai

            </div>

        </div>

        {{-- Informasi --}}
        <div class="information-grid">

            <div class="info-card">

                <span>Tanggal</span>

                <strong>

                    {{ \Carbon\Carbon::parse($sale->tanggal)->translatedFormat('d F Y') }}

                </strong>

            </div>

            <div class="info-card">

                <span>Kasir</span>

                <strong>

                    {{ $sale->user->name }}

                </strong>

            </div>

            <div class="info-card">

                <span>Total Bayar</span>

                <strong>

                    Rp {{ number_format($sale->total_bayar,0,',','.') }}

                </strong>

            </div>

            <div class="info-card">

                <span>Total Item</span>

                <strong>

                    {{ $sale->saleDetails->count() }}

                </strong>

            </div>

        </div>

        {{-- Statistik --}}
        <div class="summary-grid">

            <div class="summary-card">

                <span>Subtotal</span>

                <strong>

                    Rp {{ number_format($sale->subtotal,0,',','.') }}

                </strong>

            </div>

            <div class="summary-card">

                <span>Diskon</span>

                <strong>

                    Rp {{ number_format($sale->diskon,0,',','.') }}

                </strong>

            </div>

            <div class="summary-card">

                <span>Bayar</span>

                <strong>

                    Rp {{ number_format($sale->bayar,0,',','.') }}

                </strong>

            </div>

            <div class="summary-card">

                <span>Kembalian</span>

                <strong>

                    Rp {{ number_format($sale->kembalian,0,',','.') }}

                </strong>

            </div>

        </div>

        {{-- Daftar Barang --}}
        <div class="section-card">

            <div class="section-header">

                <h3>

                    Daftar Barang

                </h3>

            </div>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Produk</th>

                            <th>Harga</th>

                            <th>Qty</th>

                            <th>Subtotal</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($sale->saleDetails as $detail)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <td>

                                    {{ $detail->product->nama_produk }}

                                </td>

                                <td>

                                    Rp {{ number_format($detail->harga,0,',','.') }}

                                </td>

                                <td>

                                    {{ $detail->qty }}

                                </td>

                                <td>

                                    Rp {{ number_format($detail->subtotal,0,',','.') }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection 