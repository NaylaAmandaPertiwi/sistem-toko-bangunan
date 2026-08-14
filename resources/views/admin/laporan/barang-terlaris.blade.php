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

    const tanggalMulai = document.getElementById('tanggal_mulai');

    const tanggalAkhir = document.getElementById('tanggal_akhir');

    const category = document.getElementById('category');


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
            + (params.toString()
                ? '?' + params.toString()
                : ''
            );


        window.location.href = url;

    }


    category.addEventListener(
        'change',
        applyFilter
    );


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