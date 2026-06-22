@extends('layouts.app')

@section('title','Pergerakan Stok')

@section('content')

<style>

.page-card{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.page-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:30px;
    font-weight:600;
}

.page-body{
    padding:25px;
}

.stock-table{
    width:100%;
    border-collapse:collapse;
}

.stock-table th{
    background:#f3f5fa;
    padding:14px;
    text-align:left;
}

.stock-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.badge-masuk{
    background:#d4edda;
    color:#155724;
    padding:6px 12px;
    border-radius:20px;
}

.badge-keluar{
    background:#f8d7da;
    color:#721c24;
    padding:6px 12px;
    border-radius:20px;
}

.badge-opname{
    background:#d1ecf1;
    color:#0c5460;
    padding:6px 12px;
    border-radius:20px;
}

</style>

<div class="page-card">

    <div class="page-header">
        Pergerakan Stok
    </div>

    <div class="page-body">

        <form method="GET" style="margin-bottom:20px;">

            <input
                type="date"
                name="start_date"
                value="{{ request('start_date') }}">

            <input
                type="date"
                name="end_date"
                value="{{ request('end_date') }}">

            <button type="submit">
                Filter
            </button>

        </form>

    <table class="stock-table">

        <table class="stock-table">

            <thead>

                <tr>

                    <th>Tanggal</th>

                    <th>
                        <form method="GET" id="filterProdukForm">
                            <select
                                name="product_id"
                                onchange="document.getElementById('filterProdukForm').submit()"
                                style="
                                    border:none;
                                    background:transparent;
                                    font-weight:600;
                                    cursor:pointer;
                                ">
                                
                                <option value="">
                                    Semua Produk
                                </option>

                                @foreach($products as $product)
                                    <option
                                        value="{{ $product->id }}"
                                        {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->nama_produk }}
                                    </option>
                                @endforeach

                            </select>
                        </form>
                    </th>

                    <th>
                        <form method="GET" id="filterJenisForm">

                            <select
                                name="jenis"
                                onchange="document.getElementById('filterJenisForm').submit()"
                                style="
                                    border:none;
                                    background:transparent;
                                    font-weight:600;
                                    cursor:pointer;
                                ">

                                <option value="">
                                    Semua
                                </option>

                                <option value="Masuk">
                                    Masuk
                                </option>

                                <option value="Keluar">
                                    Keluar
                                </option>

                                <option value="Opname">
                                    Opname
                                </option>

                            </select>

                        </form>
                    </th>

                    <th>Qty</th>

                    <th>Stok Awal</th>
                    <th>Stok Akhir</th>
                    <th>Keterangan</th>

                </tr>

            </thead>

            <tbody>

            @forelse($movements as $item)

                <tr>

                    <td>
                        {{ date('d-m-Y', strtotime($item->tanggal)) }}
                    </td>

                    <td>
                        {{ $item->product->nama_produk }}
                    </td>

                    <td>

                        @if($item->jenis == 'Masuk')

                            <span class="badge-masuk">
                                Masuk
                            </span>

                        @elseif($item->jenis == 'Keluar')

                            <span class="badge-keluar">
                                Keluar
                            </span>

                        @else

                            <span class="badge-opname">
                                Opname
                            </span>

                        @endif

                    </td>

                    <td>{{ $item->qty }}</td>

                    <td>{{ $item->stok_awal }}</td>

                    <td>{{ $item->stok_akhir }}</td>

                    <td>{{ $item->keterangan }}</td>

                </tr>

            @empty

                <tr>

                    <td colspan="7">
                        Belum ada data
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection