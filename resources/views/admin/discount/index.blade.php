@extends('layouts.admin')

@section('title','Diskon')

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
}

.table-section{
    padding:25px;
}

.discount-table{
    width:100%;
    border-collapse:collapse;
}

.discount-table th{
    background:#f3f5fa;
    padding:14px;
    text-align:left;
}

.discount-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.status-active{
    background:#d4edda;
    color:#155724;
    padding:6px 12px;
    border-radius:20px;
}

.status-inactive{
    background:#f8d7da;
    color:#721c24;
    padding:6px 12px;
    border-radius:20px;
}

.edit-btn{
    color:#6a1b9a;
    text-decoration:none;
}

</style>

<div class="page-card">

    <div class="top-header">
        Diskon
    </div>

    <div class="filter-section">

        <form
            method="GET"
            action="{{ route('admin.discount.index') }}">

            <input
                type="text"
                name="search"
                class="search-box"
                placeholder="Cari Diskon"
                value="{{ request('search') }}"
                onkeyup="this.form.submit()">

        </form>

        <a
            href="{{ route('admin.discount.create') }}"
            class="add-btn">

            Tambah Diskon

        </a>

    </div>

    <div class="table-section">

        <table class="discount-table">

            <thead>

                <tr>

                    <th>Nama Diskon</th>
                    <th>Minimal Belanja</th>
                    <th>Diskon (%)</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($discounts as $discount)

                <tr>

                    <td>
                        {{ $discount->nama_diskon }}
                    </td>

                    <td>
                        Rp {{ number_format($discount->minimal_belanja,0,',','.') }}
                    </td>

                    <td>
                        {{ $discount->persentase_diskon }}%
                    </td>

                    <td>

                        @if($discount->status == 'Aktif')

                            <span class="status-active">
                                Aktif
                            </span>

                        @else

                            <span class="status-inactive">
                                Nonaktif
                            </span>

                        @endif

                    </td>

                    <td>

                        <a
                            href="{{ route('admin.discount.edit',$discount->id) }}"
                            class="edit-btn">

                            <i class="fa-solid fa-pen"></i>

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5">
                        Belum ada data diskon
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection