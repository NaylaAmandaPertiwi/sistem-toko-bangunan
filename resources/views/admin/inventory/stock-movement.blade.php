@extends('layouts.admin')

@section('title','Pergerakan Stok')

@section('content')

<style>   

.page-card{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.page-body{
    padding:25px;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
}

.stock-table{
    width:100%;
    min-width:1100px;
    border-collapse:collapse;
}

.stock-table th,
.stock-table td{
    white-space:nowrap;
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
}

.filter-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:20px;
}

.stock-info h2{
    margin:0;
    font-size:18px;
}

.stock-info span{
    color:#999;
}

.filter-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.filter-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.toolbar{
    display:flex;
    align-items:center;
    gap:12px;
}

.search-box{
    width:260px;
    padding:12px 15px;
    border:1px solid #ddd;
    border-radius:10px;
}

.date-range{
    display:flex;
    align-items:center;
    gap:10px;

    padding:12px 18px;

    border:1px solid #ddd;
    border-radius:10px;

    background:white;
    cursor:pointer;
}

.table-wrapper{
    overflow-x:auto;
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

.table-filter{
    border:none;
    background:transparent;
    cursor:pointer;
    font-size:12px;
    color:#666;
    margin-left:5px;
    width:auto;
}

</style>

<div class="page-card">

    <div class="top-header">
        Inventory
    </div>

    <div class="filter-section">

        <div class="filter-top">

            <div class="stock-info">

                <h2>Pergerakan Stok</h2>

                <span>
                    {{ $movements->count() }} Data Pergerakan Stok
                </span>

            </div>

        </div>

        <div class="filter-bottom">

            <select class="filter-box">
                <option>10 Baris</option>
                <option>25 Baris</option>
                <option>50 Baris</option>
            </select>

            <div class="toolbar">

                <form method="GET">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="search-box"
                        placeholder="Cari Produk"
                        onchange="this.form.submit()">

                </form>

                <button
                    type="button"
                    id="dateRangePicker"
                    class="date-range">

                    <i class="fa-regular fa-calendar"></i>

                    <span id="selectedDate">
                        Pilih Tanggal
                    </span>

                </button>

                <form id="dateFilterForm" method="GET">

                    <input
                        type="hidden"
                        name="start_date"
                        id="start_date">

                    <input
                        type="hidden"
                        name="end_date"
                        id="end_date">

                </form>

            </div>

        </div>

    </div>

    <div class="page-body">

        <div class="table-wrapper">

            <table class="stock-table">

                <thead>

                    <tr>

                        <th>Tanggal</th>

                        <th>

                            Produk

                            <form
                                method="GET"
                                id="filterProdukForm"
                                style="display:inline;">

                                <select
                                    name="product_id"
                                    class="table-filter"
                                    onchange="this.form.submit()"
                                    style="
                                        border:none;
                                        background:transparent;
                                        font-size:12px;
                                        cursor:pointer;
                                        width:18px;
                                        color:#666;
                                    ">

                                    <option value="" selected></option>

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

                            Status

                            <form
                                method="GET"
                                id="filterJenisForm"
                                style="display:inline;">

                                <select
                                    name="jenis"
                                    class="table-filter"
                                    onchange="this.form.submit()"
                                    style="
                                        border:none;
                                        background:transparent;
                                        font-size:12px;
                                        cursor:pointer;
                                        width:18px;
                                        color:#666;
                                    ">

                                    <option value=""></option>

                                    <option value="">
                                        Semua
                                    </option>

                                    <option
                                        value="Masuk"
                                        {{ request('jenis') == 'Masuk' ? 'selected' : '' }}>
                                        Masuk
                                    </option>

                                    <option
                                        value="Keluar"
                                        {{ request('jenis') == 'Keluar' ? 'selected' : '' }}>
                                        Keluar
                                    </option>

                                    <option
                                        value="Opname"
                                        {{ request('jenis') == 'Opname' ? 'selected' : '' }}>
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
                            {{ optional($item->product)->nama_produk ?? '-' }}
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

</div>

@endsection

@section('scripts')

<script>

$(function(){

    $('#dateRangePicker').daterangepicker({

        startDate: moment(),
        endDate: moment(),

        ranges: {

            'Today': [
                moment(),
                moment()
            ],

            'Yesterday': [
                moment().subtract(1,'days'),
                moment().subtract(1,'days')
            ],

            'Last 7 Days': [
                moment().subtract(6,'days'),
                moment()
            ],

            'Last 30 Days': [
                moment().subtract(29,'days'),
                moment()
            ],

            'This Month': [
                moment().startOf('month'),
                moment().endOf('month')
            ],

            'Last Month': [
                moment().subtract(1,'month').startOf('month'),
                moment().subtract(1,'month').endOf('month')
            ]
        }

    }, function(start,end){

        $('#selectedDate').text(
            start.format('DD MMM YY')
            + ' - ' +
            end.format('DD MMM YY')
        );

        $('#start_date').val(
            start.format('YYYY-MM-DD')
        );

        $('#end_date').val(
            end.format('YYYY-MM-DD')
        );

        $('#dateFilterForm').submit();

    });
});

</script>

@endsection