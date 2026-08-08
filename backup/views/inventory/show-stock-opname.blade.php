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

.status-wrapper{
    margin-bottom:20px;
}

.status-select{
    min-width:220px;
    padding:10px 15px;
    border:2px solid #1684e0;
    border-radius:10px;
    background:#fff;
    color:#1684e0;
    font-weight:600;
    font-size:14px;
    cursor:pointer;
}

.status-select:focus{
    outline:none;
    box-shadow:0 0 0 4px rgba(22,132,224,.15);
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

        <div class="status-wrapper">

            <form
                action="{{ route('stok-opname.update-status',$opname->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <select
                    name="status"
                    class="status-select"
                    onchange="this.form.submit()">

                    <option value="Draft"
                        {{ $opname->status == 'Draft' ? 'selected' : '' }}>
                        📝 Draft
                    </option>

                    <option value="Disetujui"
                        {{ $opname->status == 'Disetujui' ? 'selected' : '' }}>
                        ✔ Disetujui
                    </option>

                    <option value="Selesai"
                        {{ $opname->status == 'Selesai' ? 'selected' : '' }}>
                        ✅ Selesai
                    </option>

                    <option value="Dibatalkan"
                        {{ $opname->status == 'Dibatalkan' ? 'selected' : '' }}>
                        ❌ Dibatalkan
                    </option>

                </select>

            </form>

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
                <td>Petugas</td>
                <td>{{ $opname->petugas }}</td>
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
                href="{{ route('stok-opname.print', $opname->id) }}"
                class="btn btn-primary">

                Cetak

            </a>

        </div>

    </div>

</div>

@endsection