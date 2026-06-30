@extends('layouts.admin')

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

.badge-danger{
    background:#f8d7da;
    color:#721c24;
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

                        <th>No Opname</th>

                        <th>Tanggal</th>

                        <th>Catatan</th>

                        <th>Status</th>

                        <th>Diterima Oleh</th>

                        <th>Aksi</th>

                    </tr>

                    </thead>
                
                <tbody>

                @forelse($stockOpnames as $opname)

                <tr>

                    <td>
                        <input
                            type="checkbox"
                            class="row-checkbox"
                            value="{{ $opname->id }}">
                    </td>

                    <td>
                        {{ $opname->nomor_opname }}
                    </td>

                    <td>
                        {{ date('d-m-Y', strtotime($opname->tanggal_opname)) }}
                    </td>

                    <td>
                        {{ $opname->keterangan ?? '-' }}
                    </td>

                    <td>

                        @if($opname->status == 'Draft')

                            <span class="badge-warning">
                                Draft
                            </span>

                        @elseif($opname->status == 'Disetujui')

                            <span class="badge-info">
                                Disetujui
                            </span>

                        @elseif($opname->status == 'Selesai')

                            <span class="badge-success">
                                Selesai
                            </span>

                        @elseif($opname->status == 'Dibatalkan')

                            <span class="badge-danger">
                                Dibatalkan
                            </span>

                        @endif

                    </td>

                    <td>
                        {{ $opname->petugas }}
                    </td>

                    <td>
                        <a href="{{ route('stok-opname.show',$opname->id) }}">
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

        console.log(data);

        if(data.success)
        {
            alert('Berhasil dihapus');
            location.reload();
        }
        else
        {
            alert('Gagal hapus');
        }

    })
    .catch(error => {

        console.log(error);
        alert('Terjadi error');

    });

});

</script>

@endsection