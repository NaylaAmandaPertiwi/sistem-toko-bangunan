@extends('layouts.kasir')

@section('title','Detail Retur')

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

.summary-card.exchange-difference{

    background:#ecfdf5;

    border:1px solid #bbf7d0;

}

.summary-card.exchange-difference strong{

    color:#15803d;

}

.payment-status{

    display:flex;

    align-items:center;

    gap:15px;

    margin-top:22px;

    padding:18px 20px;

    background:#ecfdf5;

    border:1px solid #bbf7d0;

    border-radius:14px;

}

.payment-status-icon{

    width:42px;

    height:42px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#22c55e;

    color:white;

    border-radius:50%;

    flex-shrink:0;

}

.payment-status span{

    display:block;

    font-size:11px;

    font-weight:700;

    color:#15803d;

    margin-bottom:3px;

}

.payment-status strong{

    display:block;

    font-size:16px;

    color:#166534;

}

.payment-status small{

    display:block;

    margin-top:3px;

    color:#4b5563;

    font-size:13px;

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

</style>

@endsection

@section('content')

<div class="detail-container">

    {{-- Header Halaman --}}
    <div class="page-header">

        <div>

            <h1>Detail Retur</h1>

            <p>
                Informasi lengkap transaksi retur.
            </p>

        </div>

        <div class="header-action">

            <a
                href="{{ route('kasir.riwayat.index', ['tab' => 'retur']) }}"
                class="btn-back">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

            <a
                href="{{ route('print.return', $returnSale) }}"
                target="_blank"
                class="btn-print">

                <i class="fa-solid fa-print"></i>

                Cetak

            </a>

        </div>

    </div>

    {{-- Card Utama --}}
    <div class="detail-card">

        {{-- Judul Transaksi --}}
        <div class="transaction-header">

            <div>

                <h2>Transaksi Retur</h2>

                <span>

                    {{ $returnSale->kode_retur }}

                </span>

            </div>

            <div class="status-success">

                <i class="fa-solid fa-rotate-left"></i>

                Retur Selesai

            </div>

        </div>

        {{-- Informasi --}}
        <div class="information-grid">

            <div class="info-card">

                <span>Tanggal Retur</span>

                <strong>

                    {{ \Carbon\Carbon::parse($returnSale->tanggal)->translatedFormat('d F Y') }}

                </strong>

            </div>

            <div class="info-card">

                <span>Kasir</span>

                <strong>

                    {{ $returnSale->user->name }}

                </strong>

            </div>

            <div class="info-card">

                <span>Kode Penjualan</span>

                <strong>

                    {{ $returnSale->sale->kode_penjualan }}

                </strong>

            </div>

            <div class="info-card">

                <span>Total Retur</span>

                <strong>

                    Rp {{ number_format($returnSale->total_retur,0,',','.') }}

                </strong>

            </div>

        </div>

        {{-- Statistik --}}
        <div class="summary-grid">

            <div class="summary-card">

                <span>Jenis Retur</span>

                <strong>

                    {{ $returnSale->return_type === 'tukar' ? 'Tukar Barang' : 'Retur Uang' }}

                </strong>

            </div>

            <div class="summary-card">

                <span>Jumlah Item Diretur</span>

                <strong>

                    {{ $returnSale->details->count() }}

                </strong>

            </div>

            <div class="summary-card">

                <span>Total Qty Retur</span>

                <strong>

                    {{ $returnSale->details->sum('qty') }}

                </strong>

            </div>

            <div class="summary-card">

                <span>Keterangan</span>

                <strong>

                    {{ $returnSale->keterangan ?: '-' }}

                </strong>

            </div>

        </div>

        {{-- Ringkasan Nilai Retur --}}
        <div class="summary-grid">

            <div class="summary-card">

                <span>Total Nilai Retur</span>

                <strong>

                    Rp {{ number_format($returnSale->total_retur,0,',','.') }}

                </strong>

            </div>

            @if($returnSale->return_type === 'tukar')

                <div class="summary-card">

                    <span>Total Nilai Pengganti</span>

                    <strong>

                        Rp {{ number_format($returnSale->total_pengganti,0,',','.') }}

                    </strong>

                </div>

                <div class="summary-card">

                    <span>Selisih Dibayar</span>

                    <strong>

                        Rp {{ number_format($returnSale->selisih_bayar,0,',','.') }}

                    </strong>

                </div>

            @else

                <div class="summary-card">

                    <span>Uang Dikembalikan</span>

                    <strong>

                        Rp {{ number_format($returnSale->total_retur,0,',','.') }}

                    </strong>

                </div>

            @endif

        </div>

        @if(
            $returnSale->return_type === 'tukar'
            && $returnSale->selisih_bayar > 0
        )

            <div class="payment-status">

                <div class="payment-status-icon">

                    <i class="fa-solid fa-money-bill-wave"></i>

                </div>

                <div>

                    <span>STATUS PEMBAYARAN</span>

                    <strong>
                        Selisih Sudah Dibayar
                    </strong>

                    <small>
                        Rp {{ number_format(
                            $returnSale->selisih_bayar,
                            0,
                            ',',
                            '.'
                        ) }}
                        diterima dari pelanggan.
                    </small>

                </div>

            </div>

        @endif

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

                            <th>Qty Dibeli</th>

                            <th>Qty Retur</th>

                            <th>Harga</th>

                            <th>Subtotal Retur</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($returnSale->details as $detail)

                            <tr>

                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <td>

                                    {{ $detail->product->nama_produk }}

                                </td>

                                <td>

                                    {{ $detail->saleDetail->qty }}

                                </td>

                                <td>

                                    {{ $detail->qty }}

                                </td>

                                <td>

                                    Rp {{ number_format($detail->harga,0,',','.') }}

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

        {{-- Daftar Barang Pengganti --}}
        @if($returnSale->return_type === 'tukar' && $returnSale->exchangeDetails->count() > 0)

            <div class="section-card">

                <div class="section-header">

                    <h3>
                        Daftar Barang Pengganti
                    </h3>

                </div>

                <div class="table-wrapper">

                    <table>

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Produk</th>

                                <th>Qty</th>

                                <th>Harga</th>

                                <th>Subtotal</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($returnSale->exchangeDetails as $exchange)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $exchange->product->nama_produk }}
                                    </td>

                                    <td>
                                        {{ $exchange->qty }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($exchange->harga,0,',','.') }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($exchange->subtotal,0,',','.') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection 