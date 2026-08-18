@extends('layouts.admin')

@section('title', 'Detail Retur')

@section('content')

<style>

.page-header{

    background:white;

    border-radius:16px;

    overflow:hidden;

    box-shadow:0 2px 10px rgba(0,0,0,.05);

}

.top-header{

    background:#1684e0;

    color:white;

    padding:18px 25px;

    font-size:28px;

    font-weight:600;

}

.invoice-wrapper{

    padding:30px;

}

.invoice-card{

    background:white;

    border:1px solid #edf0f5;

    border-radius:16px;

    overflow:hidden;

}

.invoice-header{

    padding:25px 30px;

    border-bottom:1px solid #edf0f5;

}

.invoice-title{

    font-size:24px;

    font-weight:700;

    color:#222;

    margin-bottom:20px;

}

.status-badge{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    padding:8px 16px;

    border-radius:999px;

    font-size:13px;

    font-weight:600;

}

.status-badge.success{

    background:#d1fae5;

    color:#065f46;

    border:1px solid #a7f3d0;

}


.invoice-info{

    display:grid;

    grid-template-columns:170px auto;

    row-gap:12px;

}

/* ==========================================================
   RETURN SUMMARY
========================================================== */

.return-summary{

    display:grid;

    grid-template-columns:repeat(4,1fr);

    gap:15px;

    margin-top:25px;

}

.return-summary-card{

    background:#f8fafc;

    border:1px solid #edf0f5;

    border-radius:12px;

    padding:16px;

}

.return-summary-card span{

    display:block;

    color:#777;

    font-size:13px;

    margin-bottom:7px;

}

.return-summary-card strong{

    color:#222;

    font-size:16px;

}

.payment-status{

    margin-top:25px;

    padding:18px 20px;

    border-radius:12px;

    background:#ecfdf5;

    border:1px solid #a7f3d0;

    color:#065f46;

}

.payment-status-title{

    font-size:12px;

    font-weight:700;

    margin-bottom:5px;

}

.payment-status-value{

    font-size:17px;

    font-weight:700;

}

.payment-status-description{

    margin-top:5px;

    font-size:13px;

}

.exchange-section{

    margin-top:35px;

}

.exchange-section h3{

    margin-bottom:15px;

    font-size:18px;

    color:#222;

}

@media(max-width:900px){

    .return-summary{

        grid-template-columns:repeat(2,1fr);

    }

}

@media(max-width:600px){

    .return-summary{

        grid-template-columns:1fr;

    }

}

.invoice-label{

    font-weight:600;

    color:#666;

}

.invoice-value{

    color:#333;

}

.invoice-body{

    padding:30px;

}

.detail-table{

    width:100%;

    border-collapse:collapse;

}

.detail-table thead{

    background:#f4f6fb;

}

.detail-table th{

    padding:16px;

    text-align:left;

    font-size:14px;

}

.detail-table td{

    padding:18px 16px;

    border-top:1px solid #edf0f5;

}

.summary-box{

    width:350px;

    margin-left:auto;

    margin-top:30px;

}

.summary-item{

    display:flex;

    justify-content:space-between;

    padding:10px 0;

}

.summary-item.total{

    font-size:18px;

    font-weight:700;

    border-top:2px solid #355cc9;

    margin-top:10px;

    padding-top:16px;

}

.invoice-footer{

    padding:25px 30px;

    border-top:1px solid #edf0f5;

    display:flex;

    justify-content:flex-end;

    gap:15px;

}

.btn-secondary{

    background:#f4f6fb;

    color:#444;

    text-decoration:none;

    border-radius:10px;

    padding:12px 20px;

}

.btn-primary{

    background:#355cc9;

    color:white;

    text-decoration:none;

    border-radius:10px;

    padding:12px 20px;

}

</style>

<div class="page-header">

    <div class="top-header">

        Detail Retur

    </div>

    <div class="invoice-wrapper">

        <div class="invoice-card">

            {{-- Header transaksi --}}

            <div class="invoice-header">

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">

                    <div class="invoice-title">

                        Informasi Retur

                    </div>

                    <span class="status-badge success">

                        Retur Berhasil

                    </span>

                </div>

                    <div class="invoice-info">

                        <div class="invoice-label">

                            Kode Retur

                        </div>

                        <div class="invoice-value">

                            {{ $returnSale->kode_retur }}

                        </div>

                        <div class="invoice-label">

                            Kode Penjualan

                        </div>

                        <div class="invoice-value">

                            {{ $returnSale->sale->kode_penjualan }}

                        </div>

                        <div class="invoice-label">

                            Tanggal Retur

                        </div>

                        <div class="invoice-value">

                            {{ \Carbon\Carbon::parse($returnSale->tanggal)->translatedFormat('d F Y') }}

                        </div>

                        <div class="invoice-label">

                            Kasir

                        </div>

                        <div class="invoice-value">

                            {{ $returnSale->user->name }}

                        </div>

                    </div>

                    {{-- ==========================================================
                        RINGKASAN RETUR
                    ========================================================== --}}

                    <div class="return-summary">

                        {{-- Jenis Retur --}}
                        <div class="return-summary-card">

                            <span>Jenis Retur</span>

                            <strong>

                                @if($returnSale->return_type === 'uang')

                                    Retur Uang

                                @else

                                    Tukar Barang

                                @endif

                            </strong>

                        </div>


                        {{-- Total Nilai Retur --}}
                        <div class="return-summary-card">

                            <span>Total Nilai Retur</span>

                            <strong>

                                Rp {{ number_format($returnSale->total_retur,0,',','.') }}

                            </strong>

                        </div>


                        {{-- Nilai Pengganti --}}
                        <div class="return-summary-card">

                            <span>Total Nilai Pengganti</span>

                            <strong>

                                @if($returnSale->return_type === 'tukar')

                                    Rp {{ number_format($returnSale->total_pengganti,0,',','.') }}

                                @else

                                    -

                                @endif

                            </strong>

                        </div>


                        {{-- Selisih --}}
                        <div class="return-summary-card">

                            <span>Selisih Pembayaran</span>

                            <strong>

                                @if($returnSale->selisih_bayar > 0)

                                    Rp {{ number_format($returnSale->selisih_bayar,0,',','.') }}

                                @else

                                    -

                                @endif

                            </strong>

                        </div>

                    </div>

                    {{-- ==========================================================
                        STATUS PEMBAYARAN
                    ========================================================== --}}

                    <div class="payment-status">

                        <div class="payment-status-title">

                            STATUS PEMBAYARAN

                        </div>


                        @if($returnSale->return_type === 'uang')

                            <div class="payment-status-value">

                                Uang Dikembalikan

                            </div>

                            <div class="payment-status-description">

                                Uang sebesar
                                <strong>
                                    Rp {{ number_format($returnSale->total_retur,0,',','.') }}
                                </strong>
                                dikembalikan kepada pelanggan.

                            </div>


                        @elseif($returnSale->selisih_bayar > 0)

                            <div class="payment-status-value">

                                Selisih Sudah Dibayar

                            </div>

                            <div class="payment-status-description">

                                Pelanggan membayar selisih sebesar
                                <strong>
                                    Rp {{ number_format($returnSale->selisih_bayar,0,',','.') }}
                                </strong>.

                            </div>


                        @else

                            <div class="payment-status-value">

                                Tidak Ada Pembayaran

                            </div>

                            <div class="payment-status-description">

                                Nilai barang pengganti sama dengan nilai barang yang diretur.

                            </div>

                        @endif

                    </div>

                </div>

            {{-- Daftar barang --}}

            <div class="invoice-body">

            <table class="detail-table">

                <thead>

                <tr>

                    <th>Nama Barang</th>

                    <th>Qty Beli</th>

                    <th>Qty Retur</th>

                    <th>Harga</th>

                    <th>Total</th>

                </tr>

                </thead>

                <tbody>

                    @forelse($returnSale->details as $detail)

                    <tr>

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

                    @empty

                    <tr>

                        <td
                            colspan="5"
                            class="no-data">

                            Tidak ada data barang.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            {{-- ==========================================================
                BARANG PENGGANTI
            ========================================================== --}}

            @if($returnSale->return_type === 'tukar')

                <div class="exchange-section">

                    <h3>

                        Daftar Barang Pengganti

                    </h3>


                    <table class="detail-table">

                        <thead>

                            <tr>

                                <th>Nama Barang</th>

                                <th>Qty</th>

                                <th>Harga</th>

                                <th>Subtotal</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($returnSale->exchangeDetails as $exchange)

                                <tr>

                                    <td>

                                        {{ $exchange->product->nama_produk }}

                                    </td>

                                    <td>

                                        {{ $exchange->qty }}

                                    </td>

                                    <td>

                                        Rp
                                        {{ number_format($exchange->harga,0,',','.') }}

                                    </td>

                                    <td>

                                        Rp
                                        {{ number_format($exchange->subtotal,0,',','.') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="no-data">

                                        Tidak ada barang pengganti.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            @endif

            {{-- ==========================================================
                RINGKASAN AKHIR
            ========================================================== --}}

            <div class="summary-box">

                <div class="summary-item">

                    <span>Keterangan</span>

                    <span>

                        {{ $returnSale->keterangan ?: '-' }}

                    </span>

                </div>


                <div class="summary-item">

                    <span>Total Nilai Retur</span>

                    <span>

                        Rp {{ number_format($returnSale->total_retur,0,',','.') }}

                    </span>

                </div>


                @if($returnSale->return_type === 'tukar')

                    <div class="summary-item">

                        <span>Nilai Barang Pengganti</span>

                        <span>

                            Rp {{ number_format($returnSale->total_pengganti,0,',','.') }}

                        </span>

                    </div>


                    <div class="summary-item total">

                        <span>

                            @if($returnSale->selisih_bayar > 0)

                                Selisih Dibayar

                            @else

                                Selisih Pembayaran

                            @endif

                        </span>

                        <span>

                            @if($returnSale->selisih_bayar > 0)

                                Rp {{ number_format($returnSale->selisih_bayar,0,',','.') }}

                            @else

                                Rp 0

                            @endif

                        </span>

                    </div>

                @else

                    <div class="summary-item total">

                        <span>Uang Dikembalikan</span>

                        <span>

                            Rp {{ number_format($returnSale->total_retur,0,',','.') }}

                        </span>

                    </div>

                @endif

            </div>

            </div>

            {{-- Footer tombol --}}

            <div class="invoice-footer">

                <a
                    href="{{ route('admin.transaksi.retur') }}"
                    class="btn-secondary">

                    Kembali

                </a>

                <a
                    href="{{ route('print.return', $returnSale) }}"
                    target="_blank"
                    class="btn-primary">

                    Cetak Invoice

                </a>

            </div>

        </div>

    </div>

</div>

@endsection