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
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.category-toolbar{
    padding:25px;
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
}

.category-info h2{
    margin:0 0 4px 0;
    font-size:20px;
    font-weight:700;
    color:#111;
}

.category-info span{
    color:#999;
    font-size:16px;
}

.category-actions{
    display:flex;
    align-items:center;
    gap:12px;
}

.search-box{
    width:280px;
}

.search-box input{
    width:100%;
    box-sizing:border-box;
    padding:12px 16px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:14px;
    outline:none;
}

.search-box input:focus{
    border-color:#1684e0;
}

.add-btn{
    background:#1684e0;
    color:white;
    text-decoration:none;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
    white-space:nowrap;
}

.add-btn:hover{
    background:#1478ca;
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
<div class="category-toolbar">

    <div class="category-info">

        <h2>Daftar Kategori</h2>

        <span>
            <span id="categoryCount">{{ $categories->count() }}</span>
            Kategori
        </span>

    </div>

    <div class="category-actions">

        <div class="search-box">
            <input
                type="text"
                id="categorySearch"
                placeholder="Cari Kategori Produk"
                autocomplete="off"
            >
        </div>

        <a href="{{ route('admin.kategori-produk.create') }}"
        class="add-btn">
            Tambah Kategori
        </a>

    </div>

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

        <tbody id="categoryTableBody">

            @forelse($categories as $category)

                <tr class="category-row">

                    <td class="category-name">
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

                        <a href="{{ route('admin.kategori-produk.edit', $category->id) }}"
                        class="action-btn edit-btn">

                            <i class="fa-solid fa-pen"></i>

                        </a>

                        <form action="{{ route('admin.kategori-produk.destroy', $category->id) }}"
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

                    <td colspan="5" class="no-data">

                        Belum ada kategori produk

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('categorySearch');
    const rows = document.querySelectorAll('.category-row');
    const categoryCount = document.getElementById('categoryCount');

    searchInput.addEventListener('input', function () {

        const keyword = this.value
            .toLowerCase()
            .trim();

        let visibleCount = 0;

        rows.forEach(function (row) {

            const categoryName = row
                .querySelector('.category-name')
                .textContent
                .toLowerCase();

            if (categoryName.includes(keyword)) {

                row.style.display = '';
                visibleCount++;

            } else {

                row.style.display = 'none';

            }

        });

        categoryCount.textContent = visibleCount;

    });

});

</script>

@endsection
