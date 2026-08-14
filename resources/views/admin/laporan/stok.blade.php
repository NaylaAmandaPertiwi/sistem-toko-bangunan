@extends('layouts.admin')

@section('title', 'Laporan Stok')

@section('content')

<style>

/* =========================
   CONTAINER HALAMAN
========================= */

.page-header {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}


/* =========================
   HEADER
========================= */

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
    grid-template-columns: 2fr 1fr 1fr auto;
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
}


.filter-action {
    display: flex;
    align-items: flex-end;
    gap: 10px;
}

.btn-primary,
.btn-secondary,
.btn-pdf,
.btn-excel {
    height: 40px;
    padding: 0 18px;
    border-radius: 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    box-sizing: border-box;

    font-size: 14px;
    line-height: 1;

    white-space: nowrap;
}


.btn-primary {
    background: #355cc9;
    color: white;
}


.btn-secondary {
    background: #e9edf5;
    color: #444;
}


.btn-pdf {
    background: #dc3545;
    color: white;
}


.btn-excel {
    background: #198754;
    color: white;
}


.btn-primary:hover {
    background: #294ca8;
}


.btn-secondary:hover {
    background: #dfe4ee;
}


.btn-pdf:hover {
    background: #bb2d3b;
}


.btn-excel:hover {
    background: #157347;
}


/* =========================
   RESPONSIVE FILTER
========================= */

@media (max-width: 1000px) {

    .filter-form {
        grid-template-columns: 1fr 1fr;
    }

}


@media (max-width: 600px) {

    .filter-form {
        grid-template-columns: 1fr;
    }

    .filter-action {
        align-items: stretch;
    }

}


/* =========================
   RINGKASAN
========================= */

.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;

    margin: 25px 25px 20px 25px;
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
    margin: 20px 25px 25px 25px;

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
   BADGE STATUS
========================= */

.stock-badge {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 12px;
    font-weight: 600;
}


.stock-aman {
    background: #e8f7ee;
    color: #218838;
}


.stock-menipis {
    background: #fff4d6;
    color: #b77900;
}


.stock-habis {
    background: #fde8e8;
    color: #dc3545;
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

@media (max-width: 1000px) {

    .summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}


@media (max-width: 600px) {

    .summary-grid {
        grid-template-columns: 1fr;
    }

}

</style>


{{-- =========================
     CONTAINER HALAMAN
========================= --}}

<div class="page-header">


    {{-- =========================
         HEADER BIRU
    ========================= --}}

    <div class="top-header">
        Laporan Stok
    </div>

    {{-- =========================
        FILTER
    ========================= --}}

    <form
        method="GET"
        action="{{ route('admin.laporan.stok') }}"
        class="filter-form"
        id="stockFilterForm"
    >


        {{-- PENCARIAN PRODUK --}}

        <div class="filter-group">

            <label for="search">
                Pencarian Produk
            </label>

            <input
                type="text"
                id="search"
                name="search"
                value="{{ $search }}"
                placeholder="Nama produk, SKU, atau barcode..."
            >

        </div>


        {{-- KATEGORI --}}

        <div class="filter-group">

            <label for="category">
                Kategori
            </label>

            <select
                id="category"
                name="category"
            >

                <option value="">
                    Semua Kategori
                </option>

                @foreach($categories as $item)

                    <option
                        value="{{ $item->id }}"
                        {{ $category == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->nama_kategori }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- STATUS STOK --}}

        <div class="filter-group">

            <label for="status_stok">
                Status Stok
            </label>

            <select
                id="status_stok"
                name="status_stok"
            >

                <option
                    value=""
                    {{ $statusStok === '' ? 'selected' : '' }}
                >
                    Semua Status
                </option>

                <option
                    value="aman"
                    {{ $statusStok === 'aman' ? 'selected' : '' }}
                >
                    Aman
                </option>

                <option
                    value="menipis"
                    {{ $statusStok === 'menipis' ? 'selected' : '' }}
                >
                    Menipis
                </option>

                <option
                    value="habis"
                    {{ $statusStok === 'habis' ? 'selected' : '' }}
                >
                    Habis
                </option>

            </select>

        </div>


        {{-- TOMBOL --}}

        <div class="filter-action">

            <a
                href="{{ route('admin.laporan.stok.pdf', request()->query()) }}"
                class="btn-pdf"
            >
                🖨 Cetak PDF
            </a>

            <a
                href="{{ route('admin.laporan.stok.excel', request()->query()) }}"
                class="btn-excel"
            >
                📊 Export Excel
            </a>

        </div>

    </form>


    {{-- =========================
         RINGKASAN
    ========================= --}}

    <div class="summary-grid">


        {{-- TOTAL PRODUK --}}

        <div class="summary-card">

            <div class="summary-label">
                Total Produk
            </div>

            <div class="summary-value">
                {{ $totalProduk }}
            </div>

        </div>


        {{-- TOTAL STOK --}}

        <div class="summary-card">

            <div class="summary-label">
                Total Stok
            </div>

            <div class="summary-value">
                {{ number_format($totalStok, 0, ',', '.') }}
            </div>

        </div>


        {{-- STOK MENIPIS --}}

        <div class="summary-card">

            <div class="summary-label">
                Stok Menipis
            </div>

            <div class="summary-value">
                {{ $stokMenipis }}
            </div>

        </div>


        {{-- STOK HABIS --}}

        <div class="summary-card">

            <div class="summary-label">
                Stok Habis
            </div>

            <div class="summary-value">
                {{ $stokHabis }}
            </div>

        </div>


    </div>


    {{-- =========================
         TABEL STOK
    ========================= --}}

    <div class="table-wrapper">

        <table class="report-table">

            <thead>

                <tr>

                    <th class="text-center">
                        No
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
                        Stok
                    </th>

                    <th>
                        Satuan
                    </th>

                    <th class="text-right">
                        Stok Minimum
                    </th>

                    <th class="text-center">
                        Status
                    </th>

                </tr>

            </thead>


            <tbody id="stockTableBody">

                @forelse($products as $index => $product)

                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>


                        <td>
                            {{ $product->nama_produk }}
                        </td>


                        <td>
                            {{ $product->sku ?? '-' }}
                        </td>


                        <td>
                            {{ $product->category->nama_kategori ?? '-' }}
                        </td>


                        <td class="text-right">
                            {{ number_format($product->stok, 0, ',', '.') }}
                        </td>


                        <td>
                            {{ $product->satuan }}
                        </td>


                        <td class="text-right">
                            {{ number_format($product->stok_minimum, 0, ',', '.') }}
                        </td>


                        <td class="text-center">

                            @if($product->stok <= 0)

                                <span class="stock-badge stock-habis">
                                    Habis
                                </span>

                            @elseif($product->stok <= $product->stok_minimum)

                                <span class="stock-badge stock-menipis">
                                    Menipis
                                </span>

                            @else

                                <span class="stock-badge stock-aman">
                                    Aman
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="no-data"
                        >
                            Tidak ada data produk.
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

    const search = document.getElementById('search');
    const category = document.getElementById('category');
    const statusStok = document.getElementById('status_stok');
    const tableBody = document.getElementById('stockTableBody');

    let timer;


    function loadStockData() {

        const params = new URLSearchParams();

        if (search.value.trim() !== '') {
            params.set('search', search.value.trim());
        }

        if (category.value !== '') {
            params.set('category', category.value);
        }

        if (statusStok.value !== '') {
            params.set('status_stok', statusStok.value);
        }


        fetch(
            "{{ route('admin.laporan.stok.filter') }}?" +
            params.toString()
        )
        .then(response => response.json())
        .then(data => {

            tableBody.innerHTML = '';


            if (data.products.length === 0) {

                tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="no-data">
                            Tidak ada data produk.
                        </td>
                    </tr>
                `;

                return;
            }


            data.products.forEach((product, index) => {

                let badgeClass = '';

                if (product.status === 'Aman') {
                    badgeClass = 'stock-aman';
                } else if (product.status === 'Menipis') {
                    badgeClass = 'stock-menipis';
                } else {
                    badgeClass = 'stock-habis';
                }


                tableBody.innerHTML += `
                    <tr>

                        <td class="text-center">
                            ${index + 1}
                        </td>

                        <td>
                            ${product.nama_produk}
                        </td>

                        <td>
                            ${product.sku}
                        </td>

                        <td>
                            ${product.kategori}
                        </td>

                        <td class="text-right">
                            ${Number(product.stok).toLocaleString('id-ID')}
                        </td>

                        <td>
                            ${product.satuan}
                        </td>

                        <td class="text-right">
                            ${Number(product.stok_minimum).toLocaleString('id-ID')}
                        </td>

                        <td class="text-center">
                            <span class="stock-badge ${badgeClass}">
                                ${product.status}
                            </span>
                        </td>

                    </tr>
                `;

            });

        })
        .catch(error => {
            console.error('Gagal mengambil data stok:', error);
        });
    }


    /*
    |----------------------------------------------------------------------
    | LIVE SEARCH
    |----------------------------------------------------------------------
    */

    search.addEventListener('input', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {
            loadStockData();
        }, 300);

    });


    /*
    |----------------------------------------------------------------------
    | KATEGORI
    |----------------------------------------------------------------------
    */

    category.addEventListener('change', function () {
        loadStockData();
    });


    /*
    |----------------------------------------------------------------------
    | STATUS STOK
    |----------------------------------------------------------------------
    */

    statusStok.addEventListener('change', function () {
        loadStockData();
    });

});

</script>

@endsection