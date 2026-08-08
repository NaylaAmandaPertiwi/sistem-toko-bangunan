@extends('layouts.app')

@section('title','Retur')

@section('content')

<style>

.page-card{
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

.filter-section{
    padding:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
}

.search-box{
    width:280px;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.add-btn{
    background:#4CAF50;
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:10px;
    transition:.3s;
}

.add-btn:hover{
    background:#43a047;
}

.table-section{
    padding:25px;
}

.return-table{
    width:100%;
    border-collapse:collapse;
}

.return-table th{
    background:#f3f5fa;
    padding:15px;
    text-align:left;
}

.return-table td{
    padding:15px;
    border-bottom:1px solid #eee;
}

.detail-btn{
    color:#6a1b9a;
    text-decoration:none;
    font-size:18px;
}

.empty-data{
    text-align:center;
    color:#999;
    padding:30px;
}

</style>

<div class="page-card">

    <div class="top-header">
        Retur
    </div>

    <div class="filter-section">

        <form
            method="GET"
            action="{{ route('retur.index') }}">

            <input
                type="text"
                name="search"
                class="search-box"
                placeholder="Cari Retur..."
                value="{{ request('search') }}"
                onchange="this.form.submit()">

        </form>

        <a
            href="{{ route('retur.create') }}"
            class="add-btn">

            Tambah Retur

        </a>

    </div>

    <div class="table-section">

        <table class="return-table">

            <thead>

                <tr>

                    <th>Kode Retur</th>
                    <th>Kode Penjualan</th>
                    <th>Tanggal</th>
                    <th>Total Retur</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($returns as $retur)

                <tr>

                    <td>
                        {{ $retur->kode_retur }}
                    </td>

                    <td>
                        {{ $retur->sale->kode_penjualan }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($retur->tanggal)->format('d-m-Y') }}
                    </td>

                    <td>
                        Rp {{ number_format($retur->total_retur,0,',','.') }}
                    </td>

                    <td>
                        {{ $retur->keterangan ?? '-' }}
                    </td>

                    <td>

                        <a
                            href="{{ route('retur.show',$retur->id) }}"
                            class="detail-btn">

                            <i class="fa-solid fa-eye"></i>

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="6"
                        class="empty-data">

                        Belum ada data retur.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection