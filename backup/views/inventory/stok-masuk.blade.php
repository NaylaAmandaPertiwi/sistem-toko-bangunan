@extends('layouts.app')

@section('title', 'Stok Masuk')

@section('content')

<style>

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

/* HEADER */
.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

/* FILTER */
.filter-section{
    padding:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
}

.filter-top{
    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:20px;
}

.stock-info h2{
    margin:0;
    font-size:18px;
}

.stock-info span{
    color:#999;
}

.toolbar{
    display:flex;
    align-items:center;
    gap:10px;
}

.filter-bottom{
    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.date-range{
    display:flex;
    align-items:center;
    gap:15px;

    padding:14px 18px;

    border:1px solid #ddd;
    border-radius:10px;

    background:white;

    cursor:pointer;

    border:none;
    outline:none;

    color:#333;

    font-size:14px;
}

.date-text{
    display:flex;
    align-items:center;
    gap:10px;

    font-weight:600;
}

.search-box{
    width:260px;

    padding:12px 15px;

    border:1px solid #ddd;
    border-radius:10px;
}

.btn-primary{
    background:#1684e0;
}

.btn-primary i{
    margin-right:8px;
}

.filter-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.btn{
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    color:white;
}

.btn-primary{
    background:#1684e0;
}

/* TABLE */
.table-section{
    padding:25px;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
}

.stock-table{
    width:100%;
    min-width:1100px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f3f5fa;
    padding:12px;
    text-align:left;
    font-size:14px;
    font-weight:600;
}

table td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.no-data{
    text-align:center;
    color:#999;
    padding:40px;
}

/* DATE RANGE PICKER */
.daterangepicker .ranges li{
    padding:10px 15px;
}

.daterangepicker .ranges li.active{
    background:#1684e0;
}

.daterangepicker td.active,
.daterangepicker td.active:hover{
    background:#1684e0;
}

.daterangepicker .applyBtn{
    background:#1684e0;
    border-color:#1684e0;
}

.table-footer{
    margin-top:20px;
    display:flex;
    justify-content:flex-start;
    align-items:center;
}

.footer-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.delete-btn{
    border:none;
    background:none;
    cursor:pointer;
    color:#999;
    font-size:20px;
}

.stock-table th,
.stock-table td{
    white-space:nowrap;
}

</style>

<div class="page-header">

    @if(session('success'))

    <div style="
        margin:20px;
        padding:15px;
        background:#d4edda;
        color:#155724;
        border-radius:8px;
    ">
        {{ session('success') }}
    </div>

    @endif

    <div class="top-header">
        Inventory
    </div>

    <div class="filter-section">

        <div class="filter-top">

            <div class="stock-info">

                <h2>Daftar Stok Masuk</h2>

                <span>{{ $stockIns->count() }} Stok Masuk</span>

            </div>

            <div class="toolbar">

                <button
                    type="button"
                    id="dateRangePicker"
                    class="date-range">

                    <i class="fa-solid fa-chevron-left"></i>

                    <div class="date-text">

                        <i class="fa-regular fa-calendar"></i>

                        <span id="selectedDate">
                            02 Jun 26 - 02 Jun 26
                        </span>

                        <i class="fa-solid fa-caret-down"></i>

                    </div>

                    <i class="fa-solid fa-chevron-right"></i>

                </button>

                <a href="{{ route('stok-masuk.create') }}"
                class="btn btn-primary">

                    <i class="fa-solid fa-plus"></i>
                    Tambah

                </a>

            </div>

        </div>

        <div class="filter-bottom">

            <select class="filter-box">

                <option>10 Baris</option>
                <option>25 Baris</option>
                <option>50 Baris</option>

            </select>

            <form method="GET">

                <input
                    type="text"
                    name="search"
                    class="search-box"
                    placeholder="Cari No. Stok Masuk"
                    value="{{ request('search') }}"
                    onchange="this.form.submit()">

            </form>
        </div>

    </div>

    <form id="bulkDeleteForm"
        action="{{ route('stok-masuk.bulkDelete') }}"
        method="POST">

        @csrf
        @method('DELETE')

        <input type="hidden"
            name="ids"
            id="selectedIds">

    </form>

    <div class="table-section">

        <div class="table-wrapper">

            <table class="stock-table">

            <thead>

                <tr>
                    
                <th width="40">
                    <input type="checkbox" id="checkAll">
                </th>

                <th width="170">No Transaksi</th>

                <th width="120">Tanggal Masuk</th>

                <th width="150">Supplier</th>

                <th width="180">Produk</th>

                <th width="140">SKU</th>

                <th width="120">Harga Beli</th>

                <th width="100">Qty Stok</th>

                <th width="140">Total Harga</th>

                <th width="150">Keterangan</th>

                <th width="70">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($stockIns as $stock)

            <tr>

                <td>
                    <input
                        type="checkbox"
                        class="row-checkbox"
                        value="{{ $stock->id }}">
                </td>

                <td title="{{ $stock->nomor_transaksi }}">
                    {{ $stock->nomor_transaksi }}
                </td>

                <td>
                    {{ date('d-m-Y', strtotime($stock->tanggal_masuk)) }}
                </td>

                <td>
                    {{ $stock->supplier->nama_supplier ?? '-' }}
                </td>

                <td>
                    {{ $stock->product->nama_produk ?? '-' }}
                </td>

                <td>
                    {{ $stock->product->sku ?? '-' }}
                </td>

                <td>
                    Rp {{ number_format($stock->harga_beli,0,',','.') }}
                </td>

                <td>
                    {{ $stock->jumlah_masuk }}
                </td>

                <td>
                    Rp {{ number_format($stock->jumlah_masuk * $stock->harga_beli,0,',','.') }}
                </td>

                <td>{{ $stock->keterangan }}</td>

                <td>
                    <a href="{{ route('stok-masuk.edit',$stock->id) }}">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="11" class="no-data">
                    Belum ada data stok masuk
                </td>
            </tr>

            @endforelse

            </tbody>

            </table>

        </div>

        <div class="table-footer">

            <div class="footer-left">

                <button
                    type="button"
                    class="delete-btn"
                    onclick="bulkDelete()">

                    <i class="fa-regular fa-trash-can"></i>

                </button>

                <select class="filter-box">
                    <option>10/page</option>
                    <option>25/page</option>
                    <option>50/page</option>
                </select>

                <span>Total {{ $stockIns->count() }}</span>

            </div>

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
        autoUpdateInput: false,

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
            ],

            'This Year': [
                moment().startOf('year'),
                moment().endOf('year')
            ],

            'Last Year': [
                moment().subtract(1,'year').startOf('year'),
                moment().endOf('year')
            ]

        }

    }, function(start, end){

        $('#selectedDate').text(
            start.format('DD MMM YY')
            + ' - ' +
            end.format('DD MMM YY')
        );

        window.location.href =
            "{{ route('stok-masuk.index') }}"
            + "?start_date="
            + start.format('YYYY-MM-DD')
            + "&end_date="
            + end.format('YYYY-MM-DD');

    });

});

</script>

<script>

document.getElementById('checkAll')
?.addEventListener('change', function(){

    document
    .querySelectorAll('.row-checkbox')
    .forEach(item => {

        item.checked = this.checked;

    });

});

function bulkDelete()
{
    let ids = [];

    document
    .querySelectorAll('.row-checkbox:checked')
    .forEach(item => {

        ids.push(item.value);

    });

    if(ids.length === 0)
    {
        alert('Pilih data terlebih dahulu');
        return;
    }

    if(confirm('Hapus data yang dipilih?'))
    {
        document.getElementById('selectedIds').value =
            ids.join(',');

        document
            .getElementById('bulkDeleteForm')
            .submit();
    }
}

</script>

@endsection