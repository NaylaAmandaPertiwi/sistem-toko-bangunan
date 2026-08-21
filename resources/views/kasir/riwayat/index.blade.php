@extends('layouts.kasir')

@section('title','Riwayat Transaksi')

@section('styles')

<style>

/* =========================================================
   HEADER
========================================================= */

.page-title{

    font-size:30px;

    font-weight:700;

    color:#2d3748;

    margin-bottom:6px;

}

.page-subtitle{

    color:#777;

    margin-bottom:25px;

}


/* =========================================================
   FILTER SECTION
========================================================= */

.history-toolbar{

    background:#fff;

    border-radius:14px;

    padding:18px 20px;

    margin-bottom:20px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:15px;

    box-shadow:0 2px 8px rgba(0,0,0,.04);

    flex-wrap:wrap;

}


/* ---------------------------------------------------------
   DATE FILTER
--------------------------------------------------------- */

.date-filter-wrapper{

    position:relative;

}

.date-filter-btn{

    min-width:210px;

    height:44px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:10px;

    padding:0 15px;

    background:#fff;

    border:1px solid #ddd;

    border-radius:10px;

    cursor:pointer;

    font-size:14px;

    color:#333;

    transition:.2s;

}

.date-filter-btn:hover{

    border-color:#355cc9;

}

.date-filter-btn i:first-child{

    color:#355cc9;

}

.date-filter-dropdown{

    position:absolute;

    top:52px;

    left:0;

    width:220px;

    background:#fff;

    border:1px solid #ddd;

    border-radius:10px;

    box-shadow:0 8px 25px rgba(0,0,0,.10);

    display:none;

    overflow:hidden;

    z-index:1000;

}

.date-filter-dropdown.show{

    display:block;

}

.date-option{

    width:100%;

    border:none;

    background:#fff;

    text-align:left;

    padding:12px 16px;

    cursor:pointer;

    font-size:14px;

    color:#333;

    transition:.15s;

}

.date-option:hover{

    background:#f4f6fb;

    color:#355cc9;

}


/* =========================================================
   SEARCH
========================================================= */

.history-search{

    width:280px;

    height:44px;

    padding:0 15px 0 42px;

    border:1px solid #ddd;

    border-radius:10px;

    outline:none;

    font-size:14px;

    color:#333;

    box-sizing:border-box;

    transition:.2s;

}

.history-search:focus{

    border-color:#355cc9;

    box-shadow:0 0 0 3px rgba(53,92,201,.08);

}

.search-wrapper{

    position:relative;

}

.search-wrapper i{

    position:absolute;

    left:15px;

    top:50%;

    transform:translateY(-50%);

    color:#999;

    font-size:14px;

}


/* =========================================================
   TAB
========================================================= */

.history-tabs{

    display:flex;

    gap:12px;

    margin-bottom:20px;

}

.history-tab{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:10px;

    padding:12px 22px;

    border:none;

    border-radius:12px;

    background:#edf2f7;

    color:#555;

    cursor:pointer;

    font-size:15px;

    font-weight:600;

    transition:.25s;

}

.history-tab:hover{

    background:#dbe6ff;

}

.history-tab.active{

    background:#355cc9;

    color:white;

}

.history-badge{

    display:inline-flex;

    justify-content:center;

    align-items:center;

    min-width:24px;

    height:24px;

    padding:0 8px;

    border-radius:20px;

    background:white;

    color:#355cc9;

    font-size:12px;

    font-weight:700;

    transition:.25s;

}

.history-tab.active .history-badge{

    background:rgba(255,255,255,.25);

    color:white;

}


/* =========================================================
   CONTENT
========================================================= */

.history-content{

    display:none;

}

.history-content.active{

    display:block;

}

.empty-data{

    text-align:center;

    padding:60px 20px;

    color:#999;

    font-size:15px;

}


/* =========================================================
   TABLE
========================================================= */

.box h3{

    font-size:20px;

    font-weight:700;

    color:#2d3748;

    margin-bottom:20px;

}

table thead th{

    background:#f3f5fa;

    color:#2d3748 !important;

    font-size:15px;

    font-weight:700;

    padding:16px;

    border-bottom:2px solid #e9ecef;

}

table tbody td{

    color:#444;

    padding:16px;

    vertical-align:middle;

}

.history-table{

    width:100%;

    table-layout:fixed;

}

.history-table th,
.history-table td{

    vertical-align:middle;

}

.col-kode{

    width:24%;

}

.col-tanggal{

    width:14%;

}

.col-kasir{

    width:12%;

}

.col-total{

    width:16%;

}

.col-status{

    width:22%;

}

.col-aksi{

    width:12%;

}

.action-column{

    text-align:center;

    white-space:nowrap;

}


/* =========================================================
   DETAIL BUTTON
========================================================= */

.btn-detail{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    min-width:82px;

    padding:7px 14px;

    background:#355cc9;

    color:#fff;

    text-decoration:none;

    border-radius:8px;

    font-size:12px;

    font-weight:600;

    transition:.25s;

}

.btn-detail:hover{

    background:#2748a8;

    color:#fff;

    text-decoration:none;

    transform:translateY(-1px);

    box-shadow:0 4px 10px rgba(53,92,201,.25);

}

.btn-detail i{

    font-size:12px;

}


/* =========================================================
   STATUS BADGE
========================================================= */

.status-badge{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:6px;

    padding:7px 12px;

    border-radius:999px;

    font-size:12px;

    font-weight:600;

    white-space:nowrap;

}

.status-badge i{

    font-size:11px;

}

.status-paid{

    background:#dcfce7;

    color:#15803d;

    border:1px solid #bbf7d0;

}

.status-refund{

    background:#dcfce7;

    color:#15803d;

    border:1px solid #bbf7d0;

}

.status-none{

    background:#eff6ff;

    color:#2563eb;

    border:1px solid #dbeafe;

}


/* =========================================================
   PAGINATION
========================================================= */

.history-pagination{

    margin-top:20px;

    display:flex;

    justify-content:flex-end;

    align-items:center;

    min-height:40px;

}


/* CONTAINER PAGINATION */

.history-pagination nav{

    display:flex;

    align-items:center;

    justify-content:flex-end;

}


/* LIST PAGINATION */

.history-pagination nav > div{

    display:flex;

    align-items:center;

}


/* LINK PAGINATION */

.history-pagination a,
.history-pagination span{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    min-width:36px;

    height:36px;

    padding:0 10px;

    margin-left:4px;

    border-radius:8px;

    font-size:13px;

    line-height:1;

    text-decoration:none;

    box-sizing:border-box;

}


/* LINK AKTIF / ANGKA */

.history-pagination a{

    color:#355cc9;

    background:#fff;

    border:1px solid #e1e5ec;

}


/* HOVER */

.history-pagination a:hover{

    background:#f0f4ff;

    color:#2748a8;

    border-color:#355cc9;

}


/* HALAMAN AKTIF */

.history-pagination span[aria-current="page"]{

    background:#355cc9;

    color:#fff;

    border:1px solid #355cc9;

    font-weight:600;

}


/* DISABLED */

.history-pagination span[aria-disabled="true"]{

    color:#aaa;

    background:#f5f5f5;

    border:1px solid #eee;

}


/* IKON SVG */

.history-pagination svg{

    width:16px !important;

    height:16px !important;

    max-width:16px !important;

    max-height:16px !important;

}


/* TEKS NEXT / PREVIOUS */

.history-pagination .relative{

    white-space:nowrap;

}


/* =========================================================
   DETAIL MODAL
========================================================= */

.detail-overlay{

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.45);

    display:none;

    justify-content:center;

    align-items:center;

    z-index:999999;

}

.detail-overlay.show{

    display:flex;

}

.detail-modal{

    width:900px;

    max-width:95%;

    max-height:90vh;

    overflow:auto;

    background:white;

    border-radius:18px;

    padding:28px;

    animation:popup .25s ease;

}

.detail-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

}

.detail-header h2{

    color:#2d3748;

    font-size:24px;

}

.detail-close{

    width:42px;

    height:42px;

    border:none;

    border-radius:50%;

    background:#edf2f7;

    cursor:pointer;

    transition:.2s;

}

.detail-close:hover{

    background:#355cc9;

    color:white;

}

.detail-loading{

    text-align:center;

    padding:60px;

    color:#888;

}

/* =========================================================
   HEADER + FILTER
========================================================= */

.history-header{

    display:flex;

    align-items:flex-start;

    justify-content:space-between;

    gap:30px;

    margin-bottom:28px;

}


.history-heading{

    flex:1;

    min-width:0;

}

.history-heading .hero-title{

    margin-bottom:5px;

}

.history-heading .page-subtitle{

    margin-bottom:0;

}


/* =========================================================
   FILTER DI KANAN HEADER
========================================================= */

.history-filters{

    display:flex;

    align-items:center;

    justify-content:flex-end;

    gap:12px;

    flex-shrink:0;

}

/* =========================================================
DATE FILTER
========================================================= */

.date-filter-wrapper{

    position:relative;

}

.date-filter-btn{

    width:210px;

    height:44px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:10px;

    padding:0 15px;

    background:#fff;

    border:1px solid #ddd;

    border-radius:10px;

    cursor:pointer;

    font-size:14px;

    color:#333;

    transition:.2s;

}

.date-filter-btn:hover{

    border-color:#355cc9;

}

.date-filter-btn i:first-child{

    color:#355cc9;

}


/* =========================================================
DROPDOWN
========================================================= */

.date-filter-dropdown{

    position:absolute;

    top:52px;

    left:0;

    width:220px;

    background:#fff;

    border:1px solid #ddd;

    border-radius:10px;

    box-shadow:0 8px 25px rgba(0,0,0,.10);

    display:none;

    overflow:hidden;

    z-index:1000;

}

.date-filter-dropdown.show{

    display:block;

}

.date-option{

    width:100%;

    border:none;

    background:#fff;

    text-align:left;

    padding:12px 16px;

    cursor:pointer;

    font-size:14px;

    color:#333;

    transition:.15s;

}

.date-option:hover{

    background:#f4f6fb;

    color:#355cc9;

}


/* =========================================================
SEARCH
========================================================= */

.search-wrapper{

    position:relative;

}

.history-search{

    width:280px;

    height:44px;

    padding:0 15px 0 42px;

    border:1px solid #ddd;

    border-radius:10px;

    outline:none;

    font-size:14px;

    color:#333;

    box-sizing:border-box;

    transition:.2s;

}

.history-search:focus{

    border-color:#355cc9;

    box-shadow:
        0 0 0 3px
        rgba(53,92,201,.08);

}

.search-wrapper i{

    position:absolute;

    left:15px;

    top:50%;

    transform:translateY(-50%);

    color:#999;

    font-size:14px;

    pointer-events:none;

}


/* =========================================================
RESPONSIVE
========================================================= */

@media(max-width:1000px){

    .history-header{

        flex-direction:column;

        align-items:stretch;

    }

    .history-filters{

        justify-content:flex-start;

    }

}

@media(max-width:650px){

    .history-filters{

        flex-direction:column;

        align-items:stretch;

    }

    .date-filter-wrapper,
    .search-wrapper{

        width:100%;

    }

    .date-filter-btn,
    .history-search{

        width:100%;

    }

}


</style>

@endsection


@section('content')

{{-- =========================================================
     HEADER
========================================================= --}}

{{-- =========================================================
     HEADER + FILTER
========================================================= --}}

<div class="history-header">

    {{-- JUDUL --}}

    <div class="history-heading">

        <h1 class="hero-title">
            Riwayat Transaksi
        </h1>

        <div class="page-subtitle">
            Daftar seluruh transaksi penjualan dan retur.
        </div>

    </div>


    {{-- FILTER --}}

    <div class="history-filters">

        {{-- FILTER TANGGAL --}}

        <div class="date-filter-wrapper">

            <button
                type="button"
                class="date-filter-btn"
                id="dateFilterButton">

                <i class="fa-regular fa-calendar"></i>

                <span id="selectedFilterText">

                    @switch(request('filter'))

                        @case('today')
                            Hari Ini
                            @break

                        @case('yesterday')
                            Kemarin
                            @break

                        @case('week')
                            7 Hari Terakhir
                            @break

                        @case('month')
                            Bulan Ini
                            @break

                        @case('custom')

                            {{ request('tanggal')
                                ?: 'Pilih Tanggal' }}

                            @break

                        @default
                            Semua Tanggal

                    @endswitch

                </span>

                <i class="fa-solid fa-chevron-down"></i>

            </button>


            <div
                class="date-filter-dropdown"
                id="dateFilterDropdown">

                <button
                    type="button"
                    class="date-option"
                    data-filter="all">

                    Semua Tanggal

                </button>

                <button
                    type="button"
                    class="date-option"
                    data-filter="today">

                    Hari Ini

                </button>

                <button
                    type="button"
                    class="date-option"
                    data-filter="yesterday">

                    Kemarin

                </button>

                <button
                    type="button"
                    class="date-option"
                    data-filter="week">

                    7 Hari Terakhir

                </button>

                <button
                    type="button"
                    class="date-option"
                    data-filter="month">

                    Bulan Ini

                </button>

                <hr
                    style="
                        margin:0;
                        border:0;
                        border-top:1px solid #eee;
                    "
                >

                <button
                    type="button"
                    class="date-option"
                    id="customDate">

                    Pilih Tanggal...

                </button>

            </div>

        </div>


        {{-- SEARCH --}}

        <div class="search-wrapper">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="historySearch"
                class="history-search"
                placeholder="Cari Kode Transaksi / Retur"
                value="{{ request('search') }}"
                autocomplete="off">

        </div>

    </div>

</div>

{{-- =========================================================
     TAB
========================================================= --}}

<div class="history-tabs">

    <button
        type="button"
        class="history-tab {{ request('tab', 'penjualan') === 'penjualan' ? 'active' : '' }}"
        id="btnPenjualan">

        <span>
            Riwayat Penjualan
        </span>

        <span class="history-badge">
            {{ $sales->total() }}
        </span>

    </button>


    <button
        type="button"
        class="history-tab {{ request('tab') === 'retur' ? 'active' : '' }}"
        id="btnRetur">

        <span>
            Riwayat Retur
        </span>

        <span class="history-badge">
            {{ $returnSales->total() }}
        </span>

    </button>

</div>


{{-- =========================================================
     PENJUALAN
========================================================= --}}

<div
    id="panelPenjualan"
    class="history-content {{ request('tab', 'penjualan') === 'penjualan' ? 'active' : '' }}">

    <div class="box">

        <h3>
            Riwayat Penjualan
        </h3>


        <table class="history-table">

            <thead>

            <tr>

                <th class="col-kode">
                    Kode Transaksi
                </th>

                <th class="col-tanggal">
                    Tanggal
                </th>

                <th class="col-kasir">
                    Kasir
                </th>

                <th class="col-total">
                    Total Transaksi
                </th>

                <th class="col-aksi action-column">
                    Aksi
                </th>

            </tr>

            </thead>


            <tbody>

            @if($sales->count())

                @foreach($sales as $sale)

                <tr>

                    <td>
                        {{ $sale->kode_penjualan }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse(
                            $sale->tanggal
                        )->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $sale->user->name ?? '-' }}
                    </td>

                    <td>
                        Rp {{ number_format(
                            $sale->total_bayar,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>

                    <td class="action-column">

                        <a
                            href="{{ route(
                                'kasir.riwayat.sale.show',
                                $sale->id
                            ) }}"
                            class="btn-detail">

                            <i class="fa-solid fa-eye"></i>

                            Detail

                        </a>

                    </td>

                </tr>

                @endforeach

            @else

                <tr>

                    <td
                        colspan="5"
                        class="empty-data">

                        Belum ada data penjualan.

                    </td>

                </tr>

            @endif

            </tbody>

        </table>


        {{-- PAGINATION PENJUALAN --}}

        @if($sales->hasPages())

            <div class="history-pagination">

                {{ $sales
                    ->appends(
                        array_merge(
                            request()->except([
                                'sales_page',
                                'returns_page'
                            ]),
                            [
                                'tab' => 'penjualan'
                            ]
                        )
                    )
                    ->links()
                }}

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     RETUR
========================================================= --}}

<div
    id="panelRetur"
    class="history-content {{ request('tab') === 'retur' ? 'active' : '' }}">

    <div class="box">

        <h3>
            Riwayat Retur
        </h3>


        <table class="history-table">

            <thead>

            <tr>

                <th class="col-kode">
                    Kode Retur
                </th>

                <th class="col-tanggal">
                    Tanggal
                </th>

                <th class="col-kasir">
                    Kasir
                </th>

                <th class="col-total">
                    Total Retur
                </th>

                <th class="col-status">
                    Status Pembayaran
                </th>

                <th class="col-aksi action-column">
                    Aksi
                </th>

            </tr>

            </thead>


            <tbody>

            @if($returnSales->count())

                @foreach($returnSales as $return)

                <tr>

                    <td>
                        {{ $return->kode_retur }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse(
                            $return->tanggal
                        )->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $return->user->name ?? '-' }}
                    </td>

                    <td>
                        Rp {{ number_format(
                            $return->total_retur,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>


                    {{-- STATUS PEMBAYARAN --}}

                    <td>

                        @if($return->return_type === 'uang')

                            <span class="status-badge status-refund">

                                <i class="fa-solid fa-money-bill-transfer"></i>

                                Uang Dikembalikan

                            </span>

                        @elseif(
                            $return->return_type === 'tukar'
                            && $return->selisih_bayar > 0
                        )

                            <span class="status-badge status-paid">

                                <i class="fa-solid fa-circle-check"></i>

                                Selisih Dibayar
                                Rp {{ number_format(
                                    $return->selisih_bayar,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </span>

                        @else

                            <span class="status-badge status-none">

                                <i class="fa-solid fa-minus-circle"></i>

                                Tidak Ada Selisih

                            </span>

                        @endif

                    </td>


                    {{-- AKSI --}}

                    <td class="action-column">

                        <a
                            href="{{ route(
                                'kasir.riwayat.return.show',
                                $return->id
                            ) }}"
                            class="btn-detail">

                            <i class="fa-solid fa-eye"></i>

                            Detail

                        </a>

                    </td>

                </tr>

                @endforeach

            @else

                <tr>

                    <td
                        colspan="6"
                        class="empty-data">

                        Belum ada data retur.

                    </td>

                </tr>

            @endif

            </tbody>

        </table>


        {{-- PAGINATION RETUR --}}

        @if($returnSales->hasPages())

            <div class="history-pagination">

                {{ $returnSales
                    ->appends(
                        array_merge(
                            request()->except([
                                'sales_page',
                                'returns_page'
                            ]),
                            [
                                'tab' => 'retur'
                            ]
                        )
                    )
                    ->links()
                }}

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL DETAIL TRANSAKSI
========================================================= --}}

<div
    id="detailModal"
    class="detail-overlay">

    <div class="detail-modal">

        <div class="detail-header">

            <h2 id="detailTitle">
                Detail Transaksi
            </h2>

            <button
                type="button"
                class="detail-close"
                onclick="closeDetailModal()">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <div id="detailContent">

            <div class="detail-loading">

                Pilih transaksi untuk melihat detail.

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL PILIH TANGGAL
========================================================= --}}

<div
    class="date-modal-overlay"
    id="dateModal"
    style="
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.35);
        display:none;
        justify-content:center;
        align-items:center;
        z-index:999999;
    ">

    <div
        class="date-modal"
        style="
            width:400px;
            max-width:90%;
            background:#fff;
            border-radius:14px;
            overflow:hidden;
            box-shadow:0 12px 30px rgba(0,0,0,.15);
        ">

        <div
            style="
                padding:18px 20px;
                border-bottom:1px solid #eee;
                font-weight:600;
            ">

            <h3 style="margin:0; color:#2d3748;">

                <i class="fa-regular fa-calendar"></i>

                Pilih Tanggal

            </h3>

        </div>


        <div style="padding:20px;">

            <input
                type="date"
                id="selectedDateInput"
                style="
                    width:100%;
                    height:44px;
                    padding:0 12px;
                    border:1px solid #ddd;
                    border-radius:9px;
                    box-sizing:border-box;
                    font-size:14px;
                ">

        </div>


        <div
            style="
                display:flex;
                justify-content:flex-end;
                gap:10px;
                padding:18px 20px;
                border-top:1px solid #eee;
            ">

            <button
                type="button"
                id="closeDateModal"
                style="
                    border:none;
                    background:#eee;
                    color:#333;
                    padding:10px 18px;
                    border-radius:8px;
                    cursor:pointer;
                ">

                Batal

            </button>


            <button
                type="button"
                id="saveDateFilter"
                style="
                    border:none;
                    background:#355cc9;
                    color:#fff;
                    padding:10px 18px;
                    border-radius:8px;
                    cursor:pointer;
                ">

                Simpan

            </button>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>

/* =========================================================
   ELEMENT
========================================================= */

const dateButton =
    document.getElementById(
        'dateFilterButton'
    );

const dropdown =
    document.getElementById(
        'dateFilterDropdown'
    );

const customDate =
    document.getElementById(
        'customDate'
    );

const dateModal =
    document.getElementById(
        'dateModal'
    );

const closeDateModal =
    document.getElementById(
        'closeDateModal'
    );

const saveDateFilter =
    document.getElementById(
        'saveDateFilter'
    );

const searchInput =
    document.getElementById(
        'historySearch'
    );

const btnPenjualan =
    document.getElementById(
        'btnPenjualan'
    );

const btnRetur =
    document.getElementById(
        'btnRetur'
    );

const panelPenjualan =
    document.getElementById(
        'panelPenjualan'
    );

const panelRetur =
    document.getElementById(
        'panelRetur'
    );


/* =========================================================
   DROPDOWN FILTER TANGGAL
========================================================= */

dateButton.addEventListener(
    'click',
    function(e){

        e.stopPropagation();

        dropdown.classList.toggle(
            'show'
        );

    }
);


/* =========================================================
   TUTUP DROPDOWN
========================================================= */

document.addEventListener(
    'click',
    function(e){

        if(
            !e.target.closest(
                '.date-filter-wrapper'
            )
        ){

            dropdown.classList.remove(
                'show'
            );

        }

    }
);


/* =========================================================
   CUSTOM DATE
========================================================= */

customDate.addEventListener(
    'click',
    function(){

        dropdown.classList.remove(
            'show'
        );

        dateModal.style.display =
            'flex';

    }
);


/* =========================================================
   TUTUP MODAL
========================================================= */

closeDateModal.addEventListener(
    'click',
    function(){

        dateModal.style.display =
            'none';

    }
);


dateModal.addEventListener(
    'click',
    function(e){

        if(
            e.target === dateModal
        ){

            dateModal.style.display =
                'none';

        }

    }
);


/* =========================================================
   BUAT URL FILTER
========================================================= */

function applyFilter(
    filter,
    tanggal = null
){

    const url =
        new URL(
            window.location.origin
            +
            "{{ route('kasir.riwayat.index') }}"
                .replace(
                    window.location.origin,
                    ''
                )
        );


    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    if(
        filter
        &&
        filter !== 'all'
    ){

        url.searchParams.set(
            'filter',
            filter
        );

    }else{

        url.searchParams.delete(
            'filter'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TANGGAL CUSTOM
    |--------------------------------------------------------------------------
    */

    if(
        filter === 'custom'
        &&
        tanggal
    ){

        url.searchParams.set(
            'tanggal',
            tanggal
        );

    }else{

        url.searchParams.delete(
            'tanggal'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    const search =
        searchInput.value.trim();


    if(search){

        url.searchParams.set(
            'search',
            search
        );

    }else{

        url.searchParams.delete(
            'search'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TAB AKTIF
    |--------------------------------------------------------------------------
    */

    if(
        btnRetur.classList.contains(
            'active'
        )
    ){

        url.searchParams.set(
            'tab',
            'retur'
        );

    }else{

        url.searchParams.set(
            'tab',
            'penjualan'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | RESET PAGINATION
    |--------------------------------------------------------------------------
    */

    url.searchParams.delete(
        'sales_page'
    );

    url.searchParams.delete(
        'returns_page'
    );


    /*
    |--------------------------------------------------------------------------
    | PINDAH HALAMAN
    |--------------------------------------------------------------------------
    */

    window.location.href =
        url.toString();

}


/* =========================================================
   PILIH FILTER
========================================================= */

document
.querySelectorAll(
    '.date-option'
)
.forEach(
    function(option){

        option.addEventListener(
            'click',
            function(){

                const filter =
                    this.dataset.filter;


                if(!filter){

                    return;

                }


                applyFilter(
                    filter
                );

            }
        );

    }
);


/* =========================================================
   SIMPAN CUSTOM DATE
========================================================= */

saveDateFilter.addEventListener(
    'click',
    function(){

        const tanggal =
            document.getElementById(
                'selectedDateInput'
            ).value;


        if(!tanggal){

            alert(
                'Silakan pilih tanggal.'
            );

            return;

        }


        applyFilter(
            'custom',
            tanggal
        );

    }
);

searchInput.addEventListener(
    'input',
    function(){

        const keyword =
            this.value
                .trim()
                .toLowerCase();


        /*
        |--------------------------------------------------------------------------
        | TABEL YANG AKTIF
        |--------------------------------------------------------------------------
        */

        const activePanel =
            document.querySelector(
                '.history-content.active'
            );


        if(!activePanel){

            return;

        }


        const rows =
            activePanel.querySelectorAll(
                'tbody tr'
            );


        let visibleRows = 0;


        rows.forEach(
            function(row){

                /*
                |--------------------------------------------------------------------------
                | JANGAN MEMPROSES BARIS EMPTY
                |--------------------------------------------------------------------------
                */

                if(
                    row.querySelector(
                        '.empty-data'
                    )
                ){

                    return;

                }


                const text =
                    row.textContent
                        .toLowerCase();


                if(
                    text.includes(keyword)
                ){

                    row.style.display = '';

                    visibleRows++;

                }else{

                    row.style.display = 'none';

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | PESAN JIKA TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        let noResult =
            activePanel.querySelector(
                '.live-search-empty'
            );


        if(!noResult){

            noResult =
                document.createElement(
                    'div'
                );

            noResult.className =
                'live-search-empty';

            noResult.innerHTML = `
                <i class="fa-solid fa-magnifying-glass"></i>
                <div>
                    Data transaksi tidak ditemukan.
                </div>
            `;

            noResult.style.cssText = `
                text-align:center;
                padding:35px;
                color:#999;
                font-size:14px;
            `;

            activePanel
                .querySelector('.box')
                .appendChild(noResult);

        }


        if(
            keyword !== ''
            &&
            visibleRows === 0
        ){

            noResult.style.display =
                'block';

        }else{

            noResult.style.display =
                'none';

        }

    }
);


/* =========================================================
   TAB PENJUALAN
========================================================= */

btnPenjualan.addEventListener(
    'click',
    function(){

        const url =
            new URL(
                window.location.href
            );


        url.searchParams.set(
            'tab',
            'penjualan'
        );


        /*
        |--------------------------------------------------------------------------
        | RESET PAGE PENJUALAN
        |--------------------------------------------------------------------------
        */

        url.searchParams.delete(
            'sales_page'
        );


        window.location.href =
            url.toString();

    }
);


/* =========================================================
   TAB RETUR
========================================================= */

btnRetur.addEventListener(
    'click',
    function(){

        const url =
            new URL(
                window.location.href
            );


        url.searchParams.set(
            'tab',
            'retur'
        );


        /*
        |--------------------------------------------------------------------------
        | RESET PAGE RETUR
        |--------------------------------------------------------------------------
        */

        url.searchParams.delete(
            'returns_page'
        );


        window.location.href =
            url.toString();

    }
);


/* =========================================================
   MODAL DETAIL
========================================================= */

function openDetailModal(){

    document
        .getElementById(
            'detailModal'
        )
        .classList.add(
            'show'
        );

}


function closeDetailModal(){

    document
        .getElementById(
            'detailModal'
        )
        .classList.remove(
            'show'
        );

}

</script>

@endsection