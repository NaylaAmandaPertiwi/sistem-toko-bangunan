@extends('layouts.app')

@section('title', 'Stok Opname')

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

.filter-section{
    padding:25px;
}

.filter-top{
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
    gap:10px;
}

.btn{
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    text-decoration:none;
    color:white;
}

.btn-primary{
    background:#1684e0;
}

.btn-primary i{
    margin-right:8px;
}

.filter-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.filter-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.search-box{
    width:260px;
    padding:12px 15px;
    border:1px solid #ddd;
    border-radius:10px;
}

.table-section{
    padding:25px;
}

.table-wrapper{
    overflow-x:auto;
}

.stock-table{
    width:100%;
    border-collapse:collapse;
}

.stock-table th{
    background:#f3f5fa;
    padding:12px;
    text-align:left;
    font-size:14px;
}

.stock-table td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.no-data{
    text-align:center;
    color:#999;
    padding:40px;
}

.badge-success{
    background:#d4edda;
    color:#155724;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.badge-warning{
    background:#fff3cd;
    color:#856404;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.badge-info{
    background:#d1ecf1;
    color:#0c5460;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.action-btn{
    color:#1684e0;
    text-decoration:none;
}

.table-footer{
    margin-top:20px;
    display:flex;
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
    color:#a0a0a0;
    font-size:20px;
    padding:0;
}

.delete-btn:hover{
    color:#ff4d4f;
}

</style>

<div class="page-header">

    <div class="top-header">
        Inventory
    </div>

    <div class="filter-section">

        <div class="filter-top">

            <div class="stock-info">

                <h2>Daftar Stok Opname</h2>

                <span>
                    {{ $stockOpnames->count() }} Data Opname
                </span>

            </div>

            <div class="toolbar">

                <a
                    href="{{ route('stok-opname.create') }}"
                    class="btn btn-primary">

                    <i class="fa-solid fa-plus"></i>
                    Tambah Opname

                </a>

            </div>

        </div>

        <div class="filter-bottom">

            <select class="filter-box">

                <option>10 Baris</option>
                <option>25 Baris</option>
                <option>50 Baris</option>

            </select>

            <form
                method="GET"
                action="{{ route('stok-opname.index') }}">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="search-box"
                    placeholder="Cari No Opname / Produk / SKU">

            </form>

        </div>

    </div>

    <div class="table-section">

        <div class="table-wrapper">

            <table class="stock-table">

                <thead>

                    <tr>

                        <th width="40">
                            <input type="checkbox" id="checkAll">
                        </th>

                        <th width="170">No Opname</th>

                        <th width="120">Tanggal</th>

                        <th width="180">Produk</th>

                        <th width="140">SKU</th>

                        <th width="120">Stok Sistem</th>

                        <th width="120">Stok Fisik</th>

                        <th width="100">Selisih</th>

                        <th width="120">Status</th>

                        <th width="70">Aksi</th>

                    </tr>

                    </thead>
                
                <tbody>

                @forelse($stockOpnames as $detail)

                <tr>

                    <td>
                        <input
                            type="checkbox"
                            class="row-checkbox"
                            value="{{ $detail->id }}">
                    </td>

                    <td>
                        {{ $detail->stockOpname->nomor_opname ?? '-' }}
                    </td>

                    <td>
                        {{ date('d-m-Y', strtotime($detail->stockOpname->tanggal_opname)) }}
                    </td>

                    <td>
                        {{ $detail->product->nama_produk ?? '-' }}
                    </td>

                    <td>
                        {{ $detail->product->sku ?? '-' }}
                    </td>

                    <td>
                        {{ $detail->stok_sistem }}
                    </td>

                    <td>
                        {{ $detail->stok_fisik }}
                    </td>

                    <td>
                        @if($detail->selisih > 0)

                            <span style="color:green">
                                +{{ $detail->selisih }}
                            </span>

                        @elseif($detail->selisih < 0)

                            <span style="color:red">
                                {{ $detail->selisih }}
                            </span>

                        @else

                            0

                        @endif
                    </td>

                    <td>
                        <span class="badge-success">
                            {{ $detail->stockOpname->status ?? '-' }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('stok-opname.show', $detail->stock_opname_id) }}">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="10" class="no-data">
                        Belum ada data stok opname
                    </td>
                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="table-footer">

            <div class="footer-left">

                <button
                    id="deleteSelected"
                    class="delete-btn"
                    type="button">

                    <i class="fa-regular fa-trash-can"></i>

                </button>

                <select class="filter-box">

                    <option>10/page</option>
                    <option>25/page</option>
                    <option>50/page</option>

                </select>

                <span>

                    Total {{ $stockOpnames->count() }}

                </span>

            </div>

        </div>

    </div>

</div>

<script>

document
.getElementById('checkAll')
.addEventListener(
'change',
function(){

    document
    .querySelectorAll('.row-checkbox')
    .forEach(cb => {

        cb.checked = this.checked;

    });

});

document
.getElementById('deleteSelected')
.addEventListener(
'click',
function(){

    let ids = [];

    document
    .querySelectorAll('.row-checkbox:checked')
    .forEach(cb => {

        ids.push(cb.value);

    });

    if(ids.length == 0)
    {
        alert('Pilih data yang akan dihapus');
        return;
    }

    if(!confirm('Yakin ingin menghapus data terpilih?'))
    {
        return;
    }

    fetch(
        "{{ route('stok-opname.bulk-delete') }}",
        {
            method:'DELETE',

            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },

            body:JSON.stringify({
                ids:ids.join(',')
            })
        }
    )
    .then(response => response.json())
    .then(data => {

        if(data.success)
        {
            location.reload();
        }

    });

});

</script>

@endsection