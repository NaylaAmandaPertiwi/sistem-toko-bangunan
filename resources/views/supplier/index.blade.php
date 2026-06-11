@extends('layouts.app')

@section('title','Supplier')

@section('content')

<style>

.page-card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.page-header{
    padding:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #eee;
}

.page-header h2{
    font-size:28px;
}

.btn-add{
    background:#57c13b;
    color:white;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
}

.btn-excel{
    background:#fff;
    border:1px solid #ddd;
    color:#1684e0;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
}

.btn-excel:hover{
    background:#f5f7fb;
}

.badge-active{
    background:#d4edda;
    color:#155724;
    padding:6px 12px;
    border-radius:20px;
}

.badge-inactive{
    background:#f8d7da;
    color:#721c24;
    padding:6px 12px;
    border-radius:20px;
}

.btn-edit{
    background:#1684e0;
    color:white;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
}

.btn-delete{
    background:#dc3545;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
}

.empty-state{
    text-align:center;
    padding:80px 20px;
    color:#999;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f5f7fb;
    padding:15px;
}

table td{
    padding:15px;
    border-bottom:1px solid #eee;
}

</style>

    <div class="page-card">

        <div class="page-header">

            <div>

                <h2>Supplier</h2>

                <small>
                    {{ $suppliers->count() }} Supplier
                </small>

            </div>

            <div style="display:flex; gap:10px;">

        <a href="{{ route('supplier.export') }}"
        class="btn-excel">

            <i class="fa-solid fa-file-excel"></i>
            Download Excel

        </a>

        <a href="{{ route('supplier.create') }}"
        class="btn-add">

            <i class="fa-solid fa-plus"></i>
            Tambah

        </a>

    </div>

    </div>

    @if($suppliers->count()==0)

        <div class="empty-state">

            <h2>Tidak ada data</h2>

            <p>
                Belum ada supplier yang ditambahkan
            </p>

        </div>

    @else

        <table>

            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Telepon</th>
                    <th>Kota</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>

                <tbody>

                @foreach($suppliers as $supplier)

                <tr>

                    <td>

                        @if($supplier->foto)

                            <img src="{{ asset('storage/'.$supplier->foto) }}"
                                width="50">

                        @endif

                    </td>

                    <td>{{ $supplier->nama_supplier }}</td>

                    <td>{{ $supplier->kontak_person }}</td>

                    <td>{{ $supplier->telepon }}</td>

                    <td>{{ $supplier->kota }}</td>

                    <td>

                    @if($supplier->status == 'Aktif')

                        <span class="badge-active">
                            Aktif
                        </span>

                    @else

                        <span class="badge-inactive">
                            Nonaktif
                        </span>

                    @endif

                    </td>

                    <td>

                        <a href="{{ route('supplier.edit',$supplier->id) }}"
                        class="btn-edit">

                            Edit

                        </a>

                        <form action="{{ route('supplier.destroy',$supplier->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button class="btn-delete"
                                    onclick="return confirm('Hapus supplier ini?')">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    @endif

</div>

@endsection