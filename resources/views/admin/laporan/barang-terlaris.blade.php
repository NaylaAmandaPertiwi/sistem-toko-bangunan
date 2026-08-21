@extends('layouts.admin')

@section('title', 'Laporan Barang Terlaris')

@section('content')

<style>

.page-header {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.top-header {
    background: #1684e0;
    color: white;
    padding: 18px 25px;
    font-size: 28px;
    font-weight: 600;
}

/* =========================
   FILTER
========================= */

.filter-form {
    display: grid;

    grid-template-columns: 1fr 1fr 1.2fr auto;

    gap: 15px;

    margin: 25px;

    padding: 20px;

    background: #f8f9fc;

    border-radius: 12px;
}


.filter-group {
    display: flex;

    flex-direction: column;

    gap: 7px;
}


.filter-group label {
    font-size: 13px;

    font-weight: 600;

    color: #555;
}


.filter-group input,
.filter-group select {
    width: 100%;

    height: 40px;

    padding: 0 12px;

    border: 1px solid #ddd;

    border-radius: 8px;

    background: white;

    box-sizing: border-box;

    font-size: 14px;
}

.btn-pdf {
    height: 40px;

    padding: 0 18px;

    border-radius: 8px;

    background: #dc3545;

    color: white;

    text-decoration: none;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    box-sizing: border-box;

    font-size: 14px;

    white-space: nowrap;
}

.btn-pdf:hover {
    background: #bb2d3b;
}

.btn-excel {
    height: 40px;

    padding: 0 18px;

    border-radius: 8px;

    background: #198754;

    color: white;

    text-decoration: none;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    box-sizing: border-box;

    font-size: 14px;

    white-space: nowrap;
}

.btn-excel:hover {
    background: #157347;
}

@media (max-width: 800px) {

    .filter-form {
        grid-template-columns: 1fr 1fr 1.2fr auto auto;
    }

}

.category-dropdown {
    position: relative;
    width: 100%;
}

.category-button {
    width: 100%;
    height: 40px;

    padding: 0 12px;

    border: 1px solid #ddd;
    border-radius: 8px;

    background: white;

    display: flex;
    align-items: center;
    justify-content: space-between;

    font-size: 14px;
    color: #222;

    cursor: pointer;

    box-sizing: border-box;
}

.category-button:hover {
    border-color: #1684e0;
}

.category-arrow {
    font-size: 11px;
    color: #555;

    transition: transform .2s;
}

.category-dropdown.active .category-arrow {
    transform: rotate(180deg);
}

.category-menu {
    display: none;

    position: absolute;

    top: calc(100% + 5px);
    left: 0;

    width: 100%;

    background: white;

    border: 1px solid #ddd;
    border-radius: 8px;

    box-shadow: 0 4px 12px rgba(0,0,0,.12);

    z-index: 1000;

    overflow: hidden;

    padding: 8px;
    
    box-sizing: border-box;
}

.category-dropdown.active .category-menu {
    display: block;
}

.category-search {
    width: 100%;

    margin: 0 0 8px 0;

    padding: 9px 10px;

    border: 1px solid #ddd;

    border-radius: 7px;

    box-sizing: border-box;

    font-size: 13px;

    color: #222;

    background: #fff;

    outline: none;
}

.category-search::placeholder {
    color: #888;
}

.category-search:focus {
    border-color: #1684e0;
}

.category-options {
    max-height: 220px;

    overflow-y: auto;
}

.category-option {
    padding: 10px 12px;

    font-size: 14px;

    cursor: pointer;

    color: #222 !important;

    background: #fff;
}

.category-option:hover {
    background: #f3f6fb;

    color: #222 !important;
}

.category-option.selected {
    background: #eaf2ff;

    color: #222 !important;

    font-weight: 600;
}

.category-no-result {
    padding: 12px;

    text-align: center;

    color: #888;

    font-size: 13px;
}

/* =========================
   RINGKASAN
========================= */

.summary-grid {
    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 20px;

    margin: 25px;
}

.summary-card {
    background: white;

    border: 1px solid #edf0f5;

    border-radius: 12px;

    padding: 20px;
}

.summary-label {
    color: #777;

    font-size: 14px;

    margin-bottom: 8px;
}

.summary-value {
    font-size: 24px;

    font-weight: 700;

    color: #222;
}


/* =========================
   TABEL
========================= */

.table-wrapper {
    margin: 20px 25px 25px;

    padding-bottom: 20px;

    overflow-x: auto;
}

.report-table {
    width: 100%;

    border-collapse: collapse;
}

.report-table thead {
    background: #f4f6fb;
}

.report-table th {
    padding: 14px;

    text-align: left;

    font-size: 14px;

    font-weight: 600;

    color: #333;
}

.report-table td {
    padding: 14px;

    border-top: 1px solid #edf0f5;

    color: #444;
}

.report-table tbody tr:hover {
    background: #fafbfe;
}


/* =========================
   ALIGNMENT
========================= */

.text-center {
    text-align: center !important;
}

.text-right {
    text-align: right !important;
}


/* =========================
   PERINGKAT
========================= */

.rank-badge {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: 32px;

    height: 32px;

    border-radius: 50%;

    background: #eef3ff;

    color: #355cc9;

    font-weight: 700;

    font-size: 13px;
}


/* =========================
   DATA KOSONG
========================= */

.no-data {
    text-align: center;

    padding: 30px !important;

    color: #777;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 800px) {

    .summary-grid {
        grid-template-columns: 1fr;
    }

}

</style>


<div class="page-header">


    {{-- =========================
         HEADER
    ========================= --}}

    <div class="top-header">

        Laporan Barang Terlaris

    </div>

    {{-- =========================
        FILTER
    ========================= --}}

    <div class="filter-form" id="filterForm">

        {{-- TANGGAL MULAI --}}
        <div class="filter-group">

            <label for="tanggal_mulai">
                Tanggal Mulai
            </label>

            <input
                type="date"
                id="tanggal_mulai"
                name="tanggal_mulai"
                value="{{ $tanggalMulai }}"
            >

        </div>


        {{-- TANGGAL AKHIR --}}
        <div class="filter-group">

            <label for="tanggal_akhir">
                Tanggal Akhir
            </label>

            <input
                type="date"
                id="tanggal_akhir"
                name="tanggal_akhir"
                value="{{ $tanggalAkhir }}"
            >

        </div>


        {{-- KATEGORI --}}
        <div class="filter-group">

            <label>
                Kategori
            </label>

            <div class="category-dropdown">

                <button
                    type="button"
                    class="category-button"
                    id="categoryButton"
                >
                    <span id="categorySelectedText">
                        {{ $category ? $categories->firstWhere('id', $category)?->nama_kategori : 'Semua Kategori' }}
                    </span>

                    <span class="category-arrow">
                        ▼
                    </span>
                </button>

                <div
                    class="category-menu"
                    id="categoryMenu"
                >

                    <input
                        type="text"
                        id="categorySearch"
                        class="category-search"
                        placeholder="Cari Kategori..."
                        autocomplete="off"
                    >

                    <div
                        class="category-options"
                        id="categoryOptions"
                    >

                        <div
                            class="category-option {{ !$category ? 'selected' : '' }}"
                            data-value=""
                        >
                            Semua Kategori
                        </div>

                        @foreach($categories as $item)

                            <div
                                class="category-option {{ $category == $item->id ? 'selected' : '' }}"
                                data-value="{{ $item->id }}"
                                data-name="{{ strtolower($item->nama_kategori) }}"
                            >
                                {{ $item->nama_kategori }}
                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <input
                type="hidden"
                id="category"
                value="{{ $category }}"
            >

        </div>


        {{-- TOMBOL PDF --}}

        <div class="filter-group">

            <label>
                &nbsp;
            </label>

            <a
                href="{{ route('admin.laporan.barang-terlaris.pdf', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir,
                    'category' => $category
                ]) }}"
                class="btn-pdf"
            >
                🖨 Cetak PDF
            </a>

            <a
                href="{{ route('admin.laporan.barang-terlaris.excel', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir,
                    'category' => $category
                ]) }}"
                class="btn-excel"
            >
                📊 Export Excel
            </a>

        </div>

    </div>

    {{-- =========================
         RINGKASAN
    ========================= --}}

    <div class="summary-grid">


        <div class="summary-card">

            <div class="summary-label">

                Total Produk Terjual

            </div>

            <div class="summary-value">

                {{ number_format($totalProduk, 0, ',', '.') }}

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-label">

                Total Qty Terjual

            </div>

            <div class="summary-value">

                {{ number_format($totalQty, 0, ',', '.') }}

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-label">

                Produk Terlaris

            </div>

            <div class="summary-value">

                {{ $produkTerlaris?->product?->nama_produk ?? '-' }}

            </div>

        </div>


    </div>


    {{-- =========================
         TABEL
    ========================= --}}

    <div class="table-wrapper">

        <table class="report-table">

            <thead>

                <tr>

                    <th class="text-center">
                        Peringkat
                    </th>

                    <th>
                        Nama Produk
                    </th>

                    <th>
                        SKU
                    </th>

                    <th>
                        Kategori
                    </th>

                    <th class="text-right">
                        Total Terjual
                    </th>

                    <th>
                        Satuan
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($products as $index => $item)

                    <tr>

                        <td class="text-center">

                            <span class="rank-badge">

                                {{ $index + 1 }}

                            </span>

                        </td>


                        <td>

                            {{ $item->product->nama_produk ?? '-' }}

                        </td>


                        <td>

                            {{ $item->product->sku ?? '-' }}

                        </td>


                        <td>

                            {{ $item->product->category->nama_kategori ?? '-' }}

                        </td>


                        <td class="text-right">

                            {{ number_format($item->total_terjual, 0, ',', '.') }}

                        </td>


                        <td>

                            {{ $item->product->satuan ?? '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="no-data"
                        >

                            Belum ada data penjualan.

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

    const tanggalMulai =
        document.getElementById('tanggal_mulai');

    const tanggalAkhir =
        document.getElementById('tanggal_akhir');

    const category =
        document.getElementById('category');

    const categoryDropdown =
        document.querySelector('.category-dropdown');

    const categoryButton =
        document.getElementById('categoryButton');

    const categoryMenu =
        document.getElementById('categoryMenu');

    const categorySearch =
        document.getElementById('categorySearch');

    const categoryOptions =
        document.querySelectorAll('.category-option');

    const categorySelectedText =
        document.getElementById('categorySelectedText');


    /*
    |--------------------------------------------------------------------------
    | TERAPKAN FILTER
    |--------------------------------------------------------------------------
    */

    function applyFilter() {

        const params = new URLSearchParams();


        if (tanggalMulai.value !== '') {

            params.set(
                'tanggal_mulai',
                tanggalMulai.value
            );

        }


        if (tanggalAkhir.value !== '') {

            params.set(
                'tanggal_akhir',
                tanggalAkhir.value
            );

        }


        if (category.value !== '') {

            params.set(
                'category',
                category.value
            );

        }


        const url =
            '{{ route('admin.laporan.barang-terlaris') }}'
            +
            (
                params.toString()
                    ? '?' + params.toString()
                    : ''
            );


        window.location.href = url;

    }


    /*
    |--------------------------------------------------------------------------
    | BUKA / TUTUP DROPDOWN
    |--------------------------------------------------------------------------
    */

    categoryButton.addEventListener('click', function () {

        categoryDropdown.classList.toggle('active');

        if (categoryDropdown.classList.contains('active')) {

            categorySearch.value = '';

            categoryOptions.forEach(function(option) {

                option.style.display = 'block';

            });

            const noResult =
                document.getElementById('categoryNoResult');

            if (noResult) {
                noResult.remove();
            }

            // Fokus langsung ke search
            categorySearch.focus();
        }

    });

    /*
    |--------------------------------------------------------------------------
    | SEARCH KATEGORI
    |--------------------------------------------------------------------------
    */

    categorySearch.addEventListener('input', function () {

        const keyword = this.value.toLowerCase().trim();

        let found = false;

        categoryOptions.forEach(function (option) {

            const name = option.textContent
                .toLowerCase()
                .trim();

            // Selalu tampilkan "Semua Kategori"
            if (option.dataset.value === '') {
                option.style.display = 'block';
                return;
            }

            if (name.includes(keyword)) {

                option.style.display = 'block';
                found = true;

            } else {

                option.style.display = 'none';

            }

        });


        let noResult =
            document.getElementById('categoryNoResult');


        if (!found && keyword !== '') {

            if (!noResult) {

                noResult = document.createElement('div');

                noResult.id = 'categoryNoResult';

                noResult.className =
                    'category-no-result';

                noResult.textContent =
                    'Kategori tidak ditemukan';

                document
                    .getElementById('categoryOptions')
                    .appendChild(noResult);

            }

        } else {

            if (noResult) {
                noResult.remove();
            }

        }

    });


    /*
    |--------------------------------------------------------------------------
    | PILIH KATEGORI
    |--------------------------------------------------------------------------
    */

    categoryOptions.forEach(
        function (option) {

            option.addEventListener(
                'click',
                function () {

                    const value =
                        this.dataset.value;

                    const name =
                        this.textContent.trim();


                    category.value = value;


                    categorySelectedText.textContent =
                        name;


                    categoryDropdown.classList.remove(
                        'active'
                    );


                    categorySearch.value = '';


                    categoryOptions.forEach(
                        function (item) {

                            item.style.display =
                                'block';

                        }
                    );


                    const noResult =
                        document.getElementById(
                            'categoryNoResult'
                        );

                    if (noResult) {

                        noResult.remove();

                    }


                    applyFilter();

                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TUTUP DROPDOWN KETIKA KLIK DI LUAR
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                !categoryDropdown.contains(
                    event.target
                )
            ) {

                categoryDropdown.classList.remove(
                    'active'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    tanggalMulai.addEventListener(
        'change',
        applyFilter
    );


    tanggalAkhir.addEventListener(
        'change',
        applyFilter
    );

});

</script>

@endsection