@extends('layouts.admin')

@section('title', 'Kategori Produk')

@section('content')

<style>

/* HEADER */
.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* TOP HEADER */
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
    gap:15px;
    flex-wrap:wrap;
}

.search-box{
    flex:1;
}

.search-box input{
    width:100%;
    padding:12px 16px;
    border:1px solid #ddd;
    border-radius:10px;
}

/* BUTTON */
.add-btn{
    background:#4CAF50;
    color:white;
    text-decoration:none;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;

    display:flex;
    align-items:center;
    gap:8px;
}

.add-btn:hover{
    background:#43a047;
}

/* TABLE */
.table-section{
    padding:25px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f3f5fa;
    padding:15px;
    text-align:left;
}

table td{
    padding:15px;
    border-bottom:1px solid #eee;
}

.no-data{
    text-align:center;
    padding:40px;
    color:#999;
}

.status-active{
    background:#d1fae5;
    color:#065f46;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status-inactive{
    background:#fee2e2;
    color:#991b1b;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.action-btn{
    border:none;
    background:none;
    cursor:pointer;
    margin-right:10px;
    font-size:16px;
    text-decoration:none;
}

.edit-btn{
    color:#1684e0;
}

.delete-btn{
    color:#dc3545;
}

</style>

<div class="page-header">

<!-- HEADER -->
<div class="top-header">
    Kategori Produk
</div>

<!-- FILTER -->
<div class="filter-section">

    <form method="GET"
        action="{{ route('kategori-produk.index') }}"
        class="search-box">

        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari Kategori Produk">

    </form>

    <a href="{{ route('kategori-produk.create') }}"
    class="add-btn">

        <i class="fa-solid fa-plus"></i>
        Tambah Kategori

    </a>

</div>

<!-- TABLE -->
<div class="table-section">

    <table>

        <thead>

            <tr>

                <th>Nama Kategori</th>

                <th>Deskripsi</th>

                <th>Jumlah Produk</th>

                <th>Status</th>

                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($categories as $category)

            <tr>

                <td>
                    {{ $category->nama_kategori }}
                </td>

                <td>
                    {{ $category->deskripsi }}
                </td>

                <td>
                    {{ $category->products_count }}
                </td>

                <td>

                    <span class="{{ $category->status == 'Aktif' ? 'status-active' : 'status-inactive' }}">
                        {{ $category->status }}
                    </span>

                </td>

                <td>

                    <a href="{{ route('kategori-produk.edit', $category->id) }}"
                    class="action-btn edit-btn">

                        <i class="fa-solid fa-pen"></i>

                    </a>

                    <form action="{{ route('kategori-produk.destroy', $category->id) }}"
                        method="POST"
                        style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="action-btn delete-btn"
                                onclick="return confirm('Hapus kategori ini?')">

                            <i class="fa-solid fa-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5"
                    class="no-data">

                    Belum ada kategori produk

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
