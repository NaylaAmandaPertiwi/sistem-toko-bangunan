@extends('layouts.admin')

@section('title', 'Supplier')

@section('content')

<style>

/* ==========================================================
   HEADER
========================================================== */

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* ==========================================================
   TOP HEADER
========================================================== */

.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

/* ==========================================================
   FILTER / TOOLBAR
========================================================== */

.filter-section{
    padding:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.supplier-info{
    display:flex;
    flex-direction:column;
    gap:4px;
}

.supplier-info h2{
    margin:0;
    font-size:20px;
    font-weight:700;
    color:#222;
}

.supplier-info span{
    color:#999;
    font-size:15px;
}

/* ==========================================================
   SEARCH + TAMBAH
========================================================== */

.supplier-toolbar{
    display:flex;
    align-items:center;
    gap:12px;
}

.search-box{
    width:280px;
    height:46px;
    padding:0 15px;
    border:1px solid #ddd;
    border-radius:10px;
    font-size:14px;
    outline:none;
    box-sizing:border-box;
}

.search-box:focus{
    border-color:#1684e0;
}

/* ==========================================================
   BUTTON TAMBAH
========================================================== */

.add-btn{
    background:#1684e0;
    color:white;
    text-decoration:none;
    border:none;
    padding:12px 22px;
    height:46px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;

    display:flex;
    align-items:center;
    justify-content:center;
}

.add-btn:hover{
    background:#0f73c7;
    color:white;
}

/* ==========================================================
   BUTTON
========================================================== */

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
    color:white;
}

/* ==========================================================
   TABLE
========================================================== */

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
    font-weight:700;
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

/* ==========================================================
   STATUS
========================================================== */

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

/* ==========================================================
   ACTION
========================================================== */

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

    {{-- =====================================================
         HEADER BIRU
    ====================================================== --}}

    <div class="top-header">

        Supplier

    </div>


    {{-- =====================================================
         FILTER / INFORMASI
    ====================================================== --}}

    <div class="filter-section">

        {{-- INFORMASI SUPPLIER --}}
        <div class="supplier-info">

            <h2>
                Daftar Supplier
            </h2>

            <span>
                {{ $suppliers->count() }} Supplier
            </span>

        </div>


        {{-- SEARCH + TAMBAH --}}
        <div class="supplier-toolbar">

            <form
                method="GET"
                action="{{ route('admin.supplier.index') }}">

                <input
                    type="text"
                    id="searchSupplier"
                    name="search"
                    class="search-box"
                    placeholder="Cari Supplier"
                    value="{{ request('search') }}"
                    autocomplete="off">

            </form>


            <a
                href="{{ route('admin.supplier.create') }}"
                class="add-btn">

                Tambah

            </a>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="table-section">

        <table id="supplierTable">

            <thead>

                <tr>

                    <th>
                        Nama Supplier
                    </th>

                    <th>
                        Kontak
                    </th>

                    <th>
                        Telepon
                    </th>

                    <th>
                        Kota
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($suppliers as $supplier)

                <tr class="supplier-row">

                    <td class="supplier-name">
                        {{ $supplier->nama_supplier }}
                    </td>

                    <td>
                        {{ $supplier->kontak_person }}
                    </td>

                    <td>
                        {{ $supplier->telepon }}
                    </td>

                    <td>
                        {{ $supplier->kota }}
                    </td>

                    <td>

                        <span class="{{ $supplier->status == 'Aktif' ? 'status-active' : 'status-inactive' }}">
                            {{ $supplier->status }}
                        </span>

                    </td>

                    <td>

                        <a
                            href="{{ route('admin.supplier.edit', $supplier->id) }}"
                            class="action-btn edit-btn">

                            <i class="fa-solid fa-pen"></i>

                        </a>

                        <form
                            action="{{ route('admin.supplier.destroy', $supplier->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="action-btn delete-btn"
                                onclick="return confirm('Hapus supplier ini?')">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="no-data">

                            Belum ada supplier

                        </td>

                    </tr>

                @endforelse

                <tr id="noSearchResult" style="display:none;">

                    <td colspan="6" class="no-data">

                        Supplier tidak ditemukan.

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection

@section('scripts')

<script>

const searchSupplier =
    document.getElementById('searchSupplier');

const supplierRows =
    document.querySelectorAll('.supplier-row');

const noSearchResult =
    document.getElementById('noSearchResult');

searchSupplier.addEventListener('input', function () {

    const keyword =
        this.value.toLowerCase().trim();

    let found = 0;

    supplierRows.forEach(function (row) {

        const supplierName =
            row.querySelector('.supplier-name')
               .textContent
               .toLowerCase();

        if (supplierName.includes(keyword)) {

            row.style.display = '';

            found++;

        } else {

            row.style.display = 'none';

        }

    });

    if (found === 0 && keyword !== '') {

        noSearchResult.style.display = '';

    } else {

        noSearchResult.style.display = 'none';

    }

});

</script>

@endsection