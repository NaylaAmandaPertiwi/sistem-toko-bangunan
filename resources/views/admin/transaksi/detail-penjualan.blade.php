@extends('layouts.admin')

@section('title', 'Detail Penjualan')

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

.invoice-info{

    display:grid;

    grid-template-columns:170px auto;

    row-gap:12px;

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

        Detail Penjualan

    </div>

    <div class="invoice-wrapper">

        <div class="invoice-card">

            {{-- Header transaksi --}}

            <div class="invoice-header">

                    <div class="invoice-title">

                        Informasi Penjualan

                    </div>

                    <div class="invoice-info">

                        <div class="invoice-label">

                            Kode Penjualan

                        </div>

                        <div class="invoice-value">

                            {{ $sale->kode_penjualan }}

                        </div>

                        <div class="invoice-label">

                            Tanggal

                        </div>

                        <div class="invoice-value">

                            {{ \Carbon\Carbon::parse($sale->tanggal)->translatedFormat('d F Y') }}

                        </div>

                        <div class="invoice-label">

                            Kasir

                        </div>

                        <div class="invoice-value">

                            {{ $sale->user->name }}

                        </div>

                    </div>

                </div>

            {{-- Daftar barang --}}

            <div class="invoice-body">

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

                    @forelse($sale->saleDetails as $detail)

                    <tr>

                        <td>

                            {{ $detail->product->nama_produk }}

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
                            colspan="4"
                            class="no-data">

                            Tidak ada data barang.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            {{-- Ringkasan pembayaran --}}

            <div class="summary-box">

                <div class="summary-item">

                    <span>Subtotal</span>

                    <span>

                        Rp {{ number_format($sale->subtotal,0,',','.') }}

                    </span>

                </div>

                <div class="summary-item">

                    <span>Diskon</span>

                    <span>

                        Rp {{ number_format($sale->diskon,0,',','.') }}

                    </span>

                </div>

                <div class="summary-item total">

                    <span>Total Bayar</span>

                    <span>

                        Rp {{ number_format($sale->total_bayar,0,',','.') }}

                    </span>

                </div>

                <div class="summary-item">

                    <span>Bayar</span>

                    <span>

                        Rp {{ number_format($sale->bayar,0,',','.') }}

                    </span>

                </div>

                <div class="summary-item">

                    <span>Kembalian</span>

                    <span>

                        Rp {{ number_format($sale->kembalian,0,',','.') }}

                    </span>

                </div>

            </div>

            </div>

            {{-- Footer tombol --}}

            <div class="invoice-footer">

                <a
                    href="{{ url()->previous() }}"
                    class="btn-secondary">

                    Kembali

                </a>

                <a
                    href="{{ route('print.sale', $sale) }}"
                    target="_blank"
                    class="btn-primary">

                    Cetak Struk

                </a>

            </div>

        </div>

    </div>

</div>

@endsection