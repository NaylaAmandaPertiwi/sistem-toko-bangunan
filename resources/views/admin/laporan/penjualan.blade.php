@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

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
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;

    margin: 25px 25px 25px 25px;

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
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: white;
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
    width: 100px;
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
    gap: 7px;
}

.btn-pdf:hover {
    background: #c82333;
}

.btn-excel {
    background: #198754;
    color: white;
    gap: 7px;
}

.btn-excel:hover {
    background: #157347;
}

/* =========================
   SUMMARY
========================= */

.summary-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;

    margin: 0 25px;
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
   TABLE
========================= */

.table-wrapper {
    margin: 20px 25px 25px 25px;
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


.no-data {
    text-align: center;
    padding: 30px !important;
    color: #777;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 900px) {

    .filter-form {
        grid-template-columns: repeat(2, 1fr);
    }

}


@media (max-width: 600px) {

    .filter-form {
        grid-template-columns: 1fr;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

}

</style>

{{-- CONTAINER HALAMAN --}}
<div class="page-header">

    {{-- HEADER BIRU --}}
    <div class="top-header">
        Laporan Penjualan
    </div>

    {{-- ISI HALAMAN --}}
    <div class="page-body">

        {{-- Filter --}}
        <form
            action="{{ route('admin.laporan.penjualan') }}"
            method="GET"
            class="filter-form"
            id="filterForm"
        >

            {{-- PERIODE --}}
            <div class="filter-group">

                <label>Periode</label>

                <select
                    name="filter"
                    id="filter"
                >

                    <option value="all"
                        {{ $filter == 'all' ? 'selected' : '' }}>
                        Semua
                    </option>

                    <option value="today"
                        {{ $filter == 'today' ? 'selected' : '' }}>
                        Hari Ini
                    </option>

                    <option value="yesterday"
                        {{ $filter == 'yesterday' ? 'selected' : '' }}>
                        Kemarin
                    </option>

                    <option value="week"
                        {{ $filter == 'week' ? 'selected' : '' }}>
                        7 Hari Terakhir
                    </option>

                    <option value="month"
                        {{ $filter == 'month' ? 'selected' : '' }}>
                        Bulan Ini
                    </option>

                    <option value="custom"
                        {{ $filter == 'custom' ? 'selected' : '' }}>
                        Tanggal Tertentu
                    </option>

                </select>

            </div>


            {{-- TANGGAL --}}
            <div class="filter-group">

                <label>Tanggal</label>

                <input
                    type="date"
                    name="tanggal"
                    id="tanggal"
                    value="{{ request('tanggal') }}"
                >

            </div>


            {{-- KASIR --}}
            <div class="filter-group">

                <label>Kasir</label>

                <select
                    name="kasir"
                    id="kasir"
                >

                    <option value="">
                        Semua Kasir
                    </option>

                    @foreach($cashiers as $cashier)

                        <option
                            value="{{ $cashier->id }}"
                            {{ request('kasir') == $cashier->id ? 'selected' : '' }}
                        >
                            {{ $cashier->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- KODE PENJUALAN --}}
            <div class="filter-group">

                <label>Kode Penjualan</label>

                <input
                    type="text"
                    name="kode"
                    id="kode"
                    value="{{ request('kode') }}"
                    placeholder="Cari kode penjualan..."
                    autocomplete="off"
                >

            </div>


            {{-- EXPORT --}}
            <div class="filter-action">

                <a
                    href="{{ route('admin.laporan.penjualan.pdf') }}"
                    class="btn-pdf"
                    id="btnPdf"
                    target="_blank"
                >
                    <i class="fa-solid fa-file-pdf"></i>
                    Cetak PDF
                </a>


                <a
                    href="{{ route('admin.laporan.penjualan.excel') }}"
                    class="btn-excel"
                    id="btnExcel"
                >
                    <i class="fa-solid fa-file-excel"></i>
                    Export Excel
                </a>

            </div>

        </form>


        {{-- Ringkasan --}}

        <div class="summary-grid">

            <div class="summary-card">

                <div class="summary-label">
                    Total Transaksi
                </div>

                <div class="summary-value">
                    {{ $totalTransaksi }}
                </div>

            </div>


            <div class="summary-card">

                <div class="summary-label">
                    Total Penjualan
                </div>

                <div class="summary-value">
                    Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
                </div>

            </div>

        </div>


        {{-- Tabel --}}

        <div class="table-wrapper">

            <table class="report-table">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Kode Penjualan</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Subtotal</th>
                        <th>Diskon</th>
                        <th>Total Bayar</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($sales as $index => $sale)

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $sale->kode_penjualan }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ $sale->user->name ?? '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($sale->subtotal, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp {{ number_format($sale->diskon, 0, ',', '.') }}
                            </td>

                            <td>
                                <strong>
                                    Rp {{ number_format($sale->total_bayar, 0, ',', '.') }}
                                </strong>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="no-data"
                            >
                                Tidak ada data penjualan.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@section('scripts')

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const filterForm =
        document.getElementById('filterForm');

    const filter =
        document.getElementById('filter');

    const tanggal =
        document.getElementById('tanggal');

    const kasir =
        document.getElementById('kasir');

    const kode =
        document.getElementById('kode');

    const btnPdf =
        document.getElementById('btnPdf');

    const btnExcel =
        document.getElementById('btnExcel');

    const summaryGrid =
        document.querySelector('.summary-grid');

    const tableWrapper =
        document.querySelector('.table-wrapper');


    /*
    |--------------------------------------------------------------------------
    | MEMBUAT URL FILTER
    |--------------------------------------------------------------------------
    */

    function getFilterUrl() {

        const params =
            new URLSearchParams();


        /*
        |----------------------------------------------------------------------
        | PERIODE
        |----------------------------------------------------------------------
        */

        if (filter.value !== '') {

            params.set(
                'filter',
                filter.value
            );

        }


        /*
        |----------------------------------------------------------------------
        | TANGGAL
        |----------------------------------------------------------------------
        */

        if (tanggal.value !== '') {

            params.set(
                'tanggal',
                tanggal.value
            );

        }


        /*
        |----------------------------------------------------------------------
        | KASIR
        |----------------------------------------------------------------------
        */

        if (kasir.value !== '') {

            params.set(
                'kasir',
                kasir.value
            );

        }


        /*
        |----------------------------------------------------------------------
        | KODE PENJUALAN
        |----------------------------------------------------------------------
        */

        if (kode.value.trim() !== '') {

            params.set(
                'kode',
                kode.value.trim()
            );

        }


        const url =
            '{{ route('admin.laporan.penjualan') }}';


        return params.toString()
            ? url + '?' + params.toString()
            : url;

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE LINK PDF & EXCEL
    |--------------------------------------------------------------------------
    */

    function updateExportLinks() {

        const params =
            new URLSearchParams();


        if (filter.value !== '') {

            params.set(
                'filter',
                filter.value
            );

        }


        if (tanggal.value !== '') {

            params.set(
                'tanggal',
                tanggal.value
            );

        }


        if (kasir.value !== '') {

            params.set(
                'kasir',
                kasir.value
            );

        }


        if (kode.value.trim() !== '') {

            params.set(
                'kode',
                kode.value.trim()
            );

        }


        const query =
            params.toString()
                ? '?' + params.toString()
                : '';


        btnPdf.href =
            '{{ route('admin.laporan.penjualan.pdf') }}'
            + query;


        btnExcel.href =
            '{{ route('admin.laporan.penjualan.excel') }}'
            + query;

    }


    /*
    |--------------------------------------------------------------------------
    | LIVE SEARCH
    |--------------------------------------------------------------------------
    | Mengambil hasil tanpa reload halaman
    |--------------------------------------------------------------------------
    */

    function loadSearchResult() {

        const url =
            getFilterUrl();


        fetch(url, {

            headers: {
                'X-Requested-With':
                    'XMLHttpRequest'
            }

        })

        .then(function (response) {

            if (!response.ok) {

                throw new Error(
                    'Gagal mengambil data'
                );

            }

            return response.text();

        })

        .then(function (html) {

            const parser =
                new DOMParser();


            const documentBaru =
                parser.parseFromString(
                    html,
                    'text/html'
                );


            /*
            |--------------------------------------------------------------------------
            | SUMMARY
            |--------------------------------------------------------------------------
            */

            const summaryBaru =
                documentBaru.querySelector(
                    '.summary-grid'
                );


            /*
            |--------------------------------------------------------------------------
            | TABEL
            |--------------------------------------------------------------------------
            */

            const tableBaru =
                documentBaru.querySelector(
                    '.table-wrapper'
                );


            /*
            |--------------------------------------------------------------------------
            | UPDATE SUMMARY
            |--------------------------------------------------------------------------
            */

            if (
                summaryBaru &&
                summaryGrid
            ) {

                summaryGrid.innerHTML =
                    summaryBaru.innerHTML;

            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE TABEL
            |--------------------------------------------------------------------------
            */

            if (
                tableBaru &&
                tableWrapper
            ) {

                tableWrapper.innerHTML =
                    tableBaru.innerHTML;

            }


            /*
            |--------------------------------------------------------------------------
            | UPDATE URL BROWSER
            |--------------------------------------------------------------------------
            */

            window.history.replaceState(
                {},
                '',
                url
            );


            /*
            |--------------------------------------------------------------------------
            | UPDATE LINK EXPORT
            |--------------------------------------------------------------------------
            */

            updateExportLinks();

        })

        .catch(function (error) {

            console.error(
                'Live search error:',
                error
            );

        });

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER PERIODE
    |--------------------------------------------------------------------------
    */

    filter.addEventListener(
        'change',
        function () {

            /*
            | Jika memilih tanggal tertentu,
            | tunggu sampai tanggal dipilih.
            */

            if (
                filter.value === 'custom'
                &&
                tanggal.value === ''
            ) {

                updateExportLinks();

                return;

            }


            window.location.href =
                getFilterUrl();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    tanggal.addEventListener(
        'change',
        function () {

            if (
                tanggal.value !== ''
            ) {

                filter.value =
                    'custom';

            }


            window.location.href =
                getFilterUrl();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FILTER KASIR
    |--------------------------------------------------------------------------
    */

    kasir.addEventListener(
        'change',
        function () {

            window.location.href =
                getFilterUrl();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | LIVE SEARCH KODE PENJUALAN
    |--------------------------------------------------------------------------
    */

    let searchTimer;


    kode.addEventListener(
        'input',
        function () {

            clearTimeout(
                searchTimer
            );


            searchTimer =
                setTimeout(
                    function () {

                        loadSearchResult();

                    },
                    300
                );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | UPDATE LINK SAAT HALAMAN DIBUKA
    |--------------------------------------------------------------------------
    */

    updateExportLinks();

});

</script>

@endsection