@extends('layouts.app')

@section('title','Detail Stok Opname')

@section('content')

<style>

.page-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.page-header{
    background:#1684e0;
    color:#fff;
    padding:18px 25px;
    font-size:30px;
    font-weight:600;
}

.page-body{
    padding:25px;
}

.info-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:30px;
}

.info-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.info-table td:first-child{
    width:220px;
    font-weight:600;
}

.detail-title{
    font-size:20px;
    font-weight:600;
    margin-bottom:15px;
}

.product-table{
    width:100%;
    border-collapse:collapse;
}

.product-table th{
    background:#f3f5fa;
    padding:14px;
    text-align:left;
}

.product-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.btn-area{
    margin-top:25px;
    display:flex;
    gap:10px;
}

.btn-primary{
    background:#1684e0;
    color:white;
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
}

.btn-secondary{
    background:#6c757d;
    color:white;
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
}

.badge-success{
    background:#d4edda;
    color:#155724;
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
}

.plus{
    color:green;
    font-weight:600;
}

.minus{
    color:red;
    font-weight:600;
}

</style>

<div class="page-card">

    <div class="page-header">
        Inventory
    </div>

    <div class="page-body">

        <div class="detail-title">
            Detail Stok Opname
        </div>

        <table class="info-table">

            <tr>
                <td>No Opname</td>
                <td>{{ $opname->nomor_opname }}</td>
            </tr>

            <tr>
                <td>Tanggal</td>
                <td>{{ date('d-m-Y', strtotime($opname->tanggal_opname)) }}</td>
            </tr>

            <tr>
                <td>Status</td>
                <td>
                    <span class="badge-success">
                        {{ $opname->status }}
                    </span>
                </td>
            </tr>

            <tr>
                <td>Petugas</td>
                <td>Admin</td>
            </tr>

            <tr>
                <td>Keterangan</td>
                <td>{{ $opname->keterangan ?? '-' }}</td>
            </tr>

        </table>

        <div class="detail-title">
            Detail Produk Opname
        </div>

        <table class="product-table">

            <thead>

                <tr>
                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Stok Sistem</th>
                    <th>Stok Fisik</th>
                    <th>Selisih</th>
                </tr>

            </thead>

            <tbody>

            @foreach($opname->details as $detail)

                <tr>

                    <td>
                        {{ $detail->product->nama_produk }}
                    </td>

                    <td>
                        {{ $detail->product->sku }}
                    </td>

                    <td>
                        {{ $detail->stok_sistem }}
                    </td>

                    <td>
                        {{ $detail->stok_fisik }}
                    </td>

                    <td>

                        @if($detail->selisih > 0)

                            <span class="plus">
                                +{{ $detail->selisih }}
                            </span>

                        @elseif($detail->selisih < 0)

                            <span class="minus">
                                {{ $detail->selisih }}
                            </span>

                        @else

                            0

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

        <div class="btn-area">

            <a
                href="{{ route('stok-opname.index') }}"
                class="btn-secondary">

                Kembali

            </a>

            <a
                href="#"
                class="btn-primary">

                Cetak Berita Acara

            </a>

        </div>

    </div>

</div>

@endsection