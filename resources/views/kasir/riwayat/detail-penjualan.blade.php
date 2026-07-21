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

/* ===========================================================
   PRINT RECEIPT
   Disembunyikan pada tampilan normal
=========================================================== */

.print-receipt{

    display:none;

}

/* ===========================================================
   PRINT MODE - THERMAL RECEIPT
=========================================================== */

@media print{

    @page{

        size:80mm auto;

        margin:4mm;

    }


    /* Sembunyikan halaman aplikasi */

    body *{

        visibility:hidden;

    }


    /* Tampilkan hanya struk */

    .print-receipt,
    .print-receipt *{

        visibility:visible;

    }


    .print-receipt{

        display:block;

        position:absolute;

        left:0;

        top:0;

         width:76mm;

        max-width:76mm;

        margin:auto;

        padding:4mm;

        background:#ffffff;

        color:#000000;

        font-family:"Courier New", monospace;

        font-size:11px;

        line-height:1.4;

    }


    /* Header */

    .receipt-header{

        text-align:center;

        margin-bottom:5px;

    }

    .receipt-header h2{

        font-size:22px;

        font-weight:700;

        letter-spacing:2px;

        margin-bottom:6px;

    }

    .receipt-header p{

        font-size:11px;

        margin:2px 0;

    }


    /* Garis */

    .receipt-divider{
        border-top:1px dashed #000;
        margin:8px 0;
        height:0;
    }


    /* Judul */

    .receipt-title{

        text-align:center;

        font-size:15px;

        font-weight:700;

        letter-spacing:1px;

        margin:5px 0;

    }


    /* Informasi transaksi */

    .receipt-info{

        margin:6px 0;

    }

    .receipt-info div{

        display:flex;

        justify-content:space-between;

        gap:8px;

        margin:2px 0;

    }

    .receipt-info div span:first-child{

        flex:0 0 78px;

    }

    .receipt-info div span:last-child{

        flex:1;

        text-align:right;

        word-break:break-word;

    }


    /* Barang */

    .receipt-items{

        margin:5px 0;

    }

    .receipt-item{

        margin-bottom:7px;

    }

    .receipt-product{

        font-weight:700;

        font-size:11px;

        margin-bottom:3px;

    }

    .receipt-item-detail{

        display:flex;

        justify-content:space-between;

        gap:10px;

        padding-left:8px;

        font-size:10px;

    }


    /* Ringkasan */

    .receipt-summary div{

        display:flex;

        justify-content:space-between;

        gap:10px;

        margin:3px 0;

    }


    /* Total */

    .receipt-total{

        display:flex;

        justify-content:space-between;

        font-size:15px;

        font-weight:700;

        padding:4px 0;

    }


    /* Footer */

    .receipt-footer{

        text-align:center;

        font-size:10px;

        margin-top:12px;

    }

    .receipt-footer p{

        margin:2px 0;

    }

    .receipt-footer strong{

        display:block;

        margin:3px 0 7px;

        font-size:12px;

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


{{-- =========================================================
     STRUK KHUSUS CETAK
========================================================= --}}

<div class="print-receipt">

    {{-- Header Toko --}}
    <div class="receipt-header">

        <h2>NAYLA BANGUNAN</h2>

        <p>Toko Bahan Bangunan</p>

        <p>Jl. Kerinci, Jambi</p>

        <p>Telp. 08xxxxxxxxxx</p>

    </div>

    <div class="receipt-divider">
        
    </div>

    <div class="receipt-title">

        STRUK PENJUALAN

    </div>

    <div class="receipt-divider">
        
    </div>


    {{-- Informasi Transaksi --}}
    <div class="receipt-info">

        <div>
            <span>No. Transaksi</span>
            <span>{{ $sale->kode_penjualan }}</span>
        </div>

        <div>
            <span>Tanggal</span>
            <span>
                {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
            </span>
        </div>

        <div>
            <span>Kasir</span>
            <span>{{ $sale->user->name ?? '-' }}</span>
        </div>

    </div>


    <div class="receipt-divider">
        
    </div>


    {{-- Daftar Barang --}}
    <div class="receipt-items">

        @foreach($sale->saleDetails as $detail)

            <div class="receipt-item">

                <div class="receipt-product">

                    {{ $detail->product->nama_produk ?? '-' }}

                </div>

                <div class="receipt-item-detail">

                    <span>

                        {{ $detail->qty }}
                        x
                        {{ number_format($detail->harga,0,',','.') }}

                    </span>

                    <span>

                        {{ number_format($detail->subtotal,0,',','.') }}

                    </span>

                </div>

            </div>

        @endforeach

    </div>


    <div class="receipt-divider">
        
    </div>


    {{-- Ringkasan Pembayaran --}}
    <div class="receipt-summary">

        <div>

            <span>Subtotal</span>

            <span>
                Rp {{ number_format($sale->subtotal,0,',','.') }}
            </span>

        </div>

        <div>

            <span>Diskon</span>

            <span>
                Rp {{ number_format($sale->diskon,0,',','.') }}
            </span>

        </div>

    </div>


    <div class="receipt-divider">
        
    </div>


    <div class="receipt-total">

        <span>TOTAL</span>

        <span>
            Rp {{ number_format($sale->total_bayar,0,',','.') }}
        </span>

    </div>


    <div class="receipt-divider">
        
    </div>


    <div class="receipt-summary">

        <div>

            <span>Bayar</span>

            <span>
                Rp {{ number_format($sale->bayar,0,',','.') }}
            </span>

        </div>

        <div>

            <span>Kembalian</span>

            <span>
                Rp {{ number_format($sale->kembalian,0,',','.') }}
            </span>

        </div>

    </div>


    <div class="receipt-divider">
        
    </div>


    {{-- Footer --}}
    <div class="receipt-footer">

        <p>Terima kasih telah berbelanja di</p>

        <strong>Nayla Bangunan</strong>

        <p>Barang yang sudah dibeli</p>

        <p>harap diperiksa kembali.</p>

    </div>

</div>

@endsection 