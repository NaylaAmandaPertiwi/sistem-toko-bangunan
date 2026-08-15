@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')

<style>

/* =========================
   CONTAINER
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

    grid-template-columns: 1fr 1fr;

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


.filter-group input {
    width: 100%;

    height: 40px;

    padding: 0 12px;

    border: 1px solid #ddd;

    border-radius: 8px;

    background: white;

    box-sizing: border-box;

    font-size: 14px;
}

/* =========================
   TOMBOL EXPORT
========================= */

.export-buttons {
    display: flex;

    gap: 10px;

    align-items: center;
}


.btn-export {
    height: 40px;

    width: 140px;

    padding: 0 18px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    box-sizing: border-box;

    border-radius: 8px;

    text-decoration: none;

    border: none;

    cursor: pointer;

    font-size: 14px;

    font-weight: 500;

    color: white;
}


.btn-pdf {
    background: #dc3545;
}


.btn-excel {
    background: #16884a;
}


.btn-pdf:hover {
    background: #bb2d3b;
}


.btn-excel:hover {
    background: #14763f;
}

/* =========================
   RINGKASAN
========================= */

.summary-grid {
    display: grid;

    grid-template-columns: repeat(4, 1fr);

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
    font-size: 22px;

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
   LABA
========================= */

.profit {
    font-weight: 600;

    color: #218838;
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
        grid-template-columns: 1fr 1fr;
    }

}


@media (max-width: 700px) {

    .filter-form {
        grid-template-columns: 1fr;
    }

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

        Laporan Keuangan

    </div>


    {{-- =========================
         FILTER
    ========================= --}}

    <form
        method="GET"
        action="{{ route('admin.laporan.keuangan') }}"
        class="filter-form"
        id="filterForm"
    >

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

        <div class="export-buttons">

            <a
                href="{{ route('admin.laporan.keuangan.pdf', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir
                ]) }}"
                class="btn-export btn-pdf"
            >
                🧾 Cetak PDF
            </a>

            <a
                href="{{ route('admin.laporan.keuangan.excel', [
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_akhir' => $tanggalAkhir
                ]) }}"
                class="btn-export btn-excel"
            >
                📊 Export Excel
            </a>

        </div>


    </form>


    {{-- =========================
         RINGKASAN
    ========================= --}}

    <div class="summary-grid">


        {{-- TOTAL PENJUALAN --}}

        <div class="summary-card">

            <div class="summary-label">

                Total Penjualan

            </div>

            <div class="summary-value">

                Rp {{ number_format(
                    $totalPenjualan,
                    0,
                    ',',
                    '.'
                ) }}

            </div>

        </div>


        {{-- TOTAL DISKON --}}

        <div class="summary-card">

            <div class="summary-label">

                Total Diskon

            </div>

            <div class="summary-value">

                Rp {{ number_format(
                    $totalDiskon,
                    0,
                    ',',
                    '.'
                ) }}

            </div>

        </div>


        {{-- TOTAL HPP --}}

        <div class="summary-card">

            <div class="summary-label">

                Total HPP

            </div>

            <div class="summary-value">

                Rp {{ number_format(
                    $totalHpp,
                    0,
                    ',',
                    '.'
                ) }}

            </div>

        </div>


        {{-- LABA KOTOR --}}

        <div class="summary-card">

            <div class="summary-label">

                Laba Kotor

            </div>

            <div class="summary-value profit">

                Rp {{ number_format(
                    $labaKotor,
                    0,
                    ',',
                    '.'
                ) }}

            </div>

        </div>


    </div>


    {{-- =========================
         TABEL TRANSAKSI
    ========================= --}}

    <div class="table-wrapper">

        <table class="report-table">

            <thead>

                <tr>

                    <th class="text-center">
                        No
                    </th>

                    <th>
                        Tanggal
                    </th>

                    <th>
                        Kode Penjualan
                    </th>

                    <th>
                        Kasir
                    </th>

                    <th class="text-right">
                        Penjualan
                    </th>

                    <th class="text-right">
                        Diskon
                    </th>

                    <th class="text-right">
                        HPP
                    </th>

                    <th class="text-right">
                        Laba Kotor
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($sales as $index => $sale)

                    @php

                        $hpp = 0;

                        foreach ($sale->saleDetails as $detail) {

                            $hargaBeli =
                                $detail->product->harga_beli ?? 0;

                            $hpp +=
                                $detail->qty * $hargaBeli;

                        }

                        $laba =
                            $sale->total_bayar - $hpp;

                    @endphp


                    <tr>


                        {{-- NO --}}

                        <td class="text-center">

                            {{ $index + 1 }}

                        </td>


                        {{-- TANGGAL --}}

                        <td>

                            {{ \Carbon\Carbon::parse(
                                $sale->tanggal
                            )->format('d/m/Y') }}

                        </td>


                        {{-- KODE --}}

                        <td>

                            {{ $sale->kode_penjualan }}

                        </td>


                        {{-- KASIR --}}

                        <td>

                            {{ $sale->user->name ?? '-' }}

                        </td>


                        {{-- PENJUALAN --}}

                        <td class="text-right">

                            Rp {{ number_format(
                                $sale->total_bayar,
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                        {{-- DISKON --}}

                        <td class="text-right">

                            Rp {{ number_format(
                                $sale->diskon,
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                        {{-- HPP --}}

                        <td class="text-right">

                            Rp {{ number_format(
                                $hpp,
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                        {{-- LABA --}}

                        <td class="text-right profit">

                            Rp {{ number_format(
                                $laba,
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="8"
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

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const tanggalMulai =
            document.getElementById(
                'tanggal_mulai'
            );

        const tanggalAkhir =
            document.getElementById(
                'tanggal_akhir'
            );

        const pdfButton =
            document.getElementById(
                'pdfButton'
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE URL PDF
        |--------------------------------------------------------------------------
        */

        function updatePdfUrl() {

            const params =
                new URLSearchParams();


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


            const baseUrl =
                '{{ route('admin.laporan.keuangan.pdf') }}';


            pdfButton.href =
                baseUrl
                + (
                    params.toString()
                        ? '?' + params.toString()
                        : ''
                );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        function applyFilter() {

            const params =
                new URLSearchParams();


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


            const url =
                '{{ route(
                    'admin.laporan.keuangan'
                ) }}'
                + (
                    params.toString()
                        ? '?' + params.toString()
                        : ''
                );


            window.location.href = url;

        }


        /*
        |--------------------------------------------------------------------------
        | EVENT FILTER
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


        /*
        |--------------------------------------------------------------------------
        | URL PDF SAAT HALAMAN DIBUKA
        |--------------------------------------------------------------------------
        */

        updatePdfUrl();

    }

);

</script>

@endsection