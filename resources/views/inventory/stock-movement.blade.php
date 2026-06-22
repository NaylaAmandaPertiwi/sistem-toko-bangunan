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

        <table class="stock-table">

            <thead>

                <tr>

                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Jenis</th>
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
                        {{ date('d-m-Y H:i',strtotime($item->tanggal)) }}
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