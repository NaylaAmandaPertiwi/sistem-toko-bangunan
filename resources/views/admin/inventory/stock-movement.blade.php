@extends('layouts.admin')

@section('title','Pergerakan Stok')

@section('content')

<style>   

.page-card{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.page-body{
    padding:25px;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
}

.stock-table{
    width:100%;
    min-width:1100px;
    border-collapse:collapse;
}

.stock-table th,
.stock-table td{
    white-space:nowrap;
}

.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

.filter-section{
    padding:25px;
}

/* ==========================================================
   JUDUL + FILTER KANAN
========================================================== */

.filter-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
}

.stock-info h2{
    margin:0;
    font-size:18px;
}

.stock-info span{
    color:#999;
    display:block;
    margin-top:4px;
}

/* ==========================================================
   TOOLBAR KANAN
========================================================== */

.toolbar{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:15px;
}

/* SEARCH */

.search-box{
    width:285px;
    height:46px;
    padding:0 15px;

    border:1px solid #ddd;
    border-radius:10px;

    outline:none;
    font-size:14px;
    box-sizing:border-box;
}

.search-box:focus{
    border-color:#1684e0;
}

/* ==========================================================
   DROPDOWN PRODUK
========================================================== */

.product-filter{
    position:relative;
}

.product-filter-btn{
    width:220px;
    height:46px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:0 15px;

    background:#fff;

    border:1px solid #ddd;
    border-radius:10px;

    cursor:pointer;

    font-size:14px;

    box-sizing:border-box;
}

.product-filter-btn:hover{
    border-color:#1684e0;
}

.product-filter-btn i{
    font-size:11px;
    color:#666;

    transition:transform .2s ease;
}

.product-filter.active
.product-filter-btn i{
    transform:rotate(180deg);
}

.product-filter-dropdown{
    position:absolute;

    top:54px;
    left:0;

    width:280px;

    max-height:360px;

    background:#fff;

    border:1px solid #ddd;
    border-radius:10px;

    box-shadow:0 8px 25px rgba(0,0,0,.10);

    display:none;

    overflow:hidden;

    z-index:4000;
}

.product-filter-dropdown.show{
    display:block;
}

.product-search-wrapper{
    padding:10px;

    border-bottom:1px solid #eee;

    background:#fff;
}

.product-search-input{
    width:100%;
    height:40px;

    padding:0 12px;

    border:1px solid #ddd;
    border-radius:8px;

    outline:none;

    font-size:14px;

    box-sizing:border-box;
}

.product-search-input:focus{
    border-color:#1684e0;
}

.product-options{
    max-height:290px;

    overflow-y:auto;
}

.product-option{
    width:100%;

    padding:12px 15px;

    border:none;

    background:#fff;

    text-align:left;

    cursor:pointer;

    font-size:14px;

    color:#222;
}

.product-option:hover{
    background:#f4f6fb;
}

.product-option.active{
    background:#f4f6fb;
    font-weight:600;
}

/* ==========================================================
   DROPDOWN TANGGAL
========================================================== */

.date-toolbar{
    position:relative;
}

.date-filter-btn{

    width:230px;
    height:46px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:0 15px;

    background:#fff;

    border:1px solid #ddd;
    border-radius:10px;

    cursor:pointer;

    font-size:14px;
}

.date-filter-btn:hover{
    border-color:#1684e0;
}

.date-filter-dropdown{

    position:absolute;

    top:54px;
    right:0;

    width:230px;

    background:#fff;

    border:1px solid #ddd;
    border-radius:10px;

    box-shadow:0 8px 25px rgba(0,0,0,.08);

    display:none;

    overflow:hidden;

    z-index:1000;
}

.date-filter-dropdown.show{
    display:block;
}

.date-option{

    width:100%;

    padding:12px 16px;

    border:none;

    background:white;

    text-align:left;

    cursor:pointer;

    font-size:14px;
}

.date-option:hover{
    background:#f4f6fb;
}

.date-option.active{
    background:#f4f6fb;
    font-weight:600;
}

/* ==========================================================
   BARIS
========================================================== */

.rows-toolbar{
    margin-top:25px;
}

.rows-select{

    height:46px;

    padding:0 12px;

    border:1px solid #ddd;
    border-radius:10px;

    background:#fff;

    font-size:14px;

    cursor:pointer;
}

/* ==========================================================
   MODAL TANGGAL CUSTOM
========================================================== */

.date-modal-overlay{

    position:fixed;
    inset:0;

    background:rgba(0,0,0,.35);

    display:none;

    justify-content:center;
    align-items:center;

    z-index:9999;
}

.date-modal-overlay.show{
    display:flex;
}

.date-modal{

    width:400px;

    background:white;

    border-radius:14px;

    overflow:hidden;

    box-shadow:0 12px 30px rgba(0,0,0,.15);
}

.date-modal-header{
    padding:18px 20px;
    border-bottom:1px solid #eee;
}

.date-modal-body{
    padding:20px;
}

.date-modal-footer{

    display:flex;

    justify-content:flex-end;

    gap:10px;

    padding:18px 20px;

    border-top:1px solid #eee;
}

.date-input{

    width:100%;

    height:45px;

    padding:0 12px;

    border:1px solid #ddd;

    border-radius:8px;

    box-sizing:border-box;
}

.btn-cancel-modal{

    padding:9px 18px;

    border:none;

    border-radius:8px;

    background:#eee;

    cursor:pointer;
}

.btn-confirm{

    padding:9px 18px;

    border:none;

    border-radius:8px;

    background:#1684e0;

    color:white;

    cursor:pointer;
}

.table-wrapper{
    overflow-x:auto;
}

.stock-table th{
    background:#f3f5fa;
    padding:14px;
    text-align:left;
}

.stock-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.badge-masuk{
    background:#d4edda;
    color:#155724;
    padding:6px 12px;
    border-radius:20px;
}

.badge-keluar{
    background:#f8d7da;
    color:#721c24;
    padding:6px 12px;
    border-radius:20px;
}

.badge-retur{
    background:#fff3cd;
    color:#856404;
    padding:6px 12px;
    border-radius:20px;
}

.badge-opname{
    background:#d1ecf1;
    color:#0c5460;
    padding:6px 12px;
    border-radius:20px;
}

.table-filter{
    border:none;
    background:transparent;
    cursor:pointer;
    font-size:12px;
    color:#666;
    margin-left:5px;
    width:auto;
}

/* ==========================================================
   DROPDOWN STATUS - TOOLBAR
========================================================== */

.status-filter{
    position:relative;
    display:inline-block;
}

.status-filter-btn{

    width:180px;
    height:46px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    padding:0 15px;

    border:1px solid #ddd;
    border-radius:10px;

    background:#fff;

    font-size:14px;
    font-weight:400;

    color:#222;

    cursor:pointer;

    box-sizing:border-box;
}

.status-filter-btn:hover{
    border-color:#1684e0;
}

.status-filter-btn i{
    font-size:11px;
    color:#666;

    transition:transform .2s ease;
}

.status-filter.active .status-filter-btn i{
    transform:rotate(180deg);
}

.status-filter-dropdown{

    position:absolute;

    top:54px;
    left:0;

    width:180px;

    background:#fff;

    border:1px solid #ddd;
    border-radius:10px;

    box-shadow:0 8px 25px rgba(0,0,0,.10);

    display:none;

    overflow:hidden;

    z-index:3000;
}

.status-filter-dropdown.show{
    display:block;
}

.status-option{

    width:100%;

    padding:12px 15px;

    border:none;

    background:#fff;

    text-align:left;

    font-size:14px;

    color:#222;

    cursor:pointer;
}

.status-option:hover{
    background:#f4f6fb;
}

.status-option.active{
    background:#f4f6fb;
    font-weight:600;
}

</style>

<div class="page-card">

    <div class="top-header">
        Inventory
    </div>

    <div class="filter-section">

        <div class="filter-top">

            {{-- JUDUL --}}
            <div class="stock-info">

                <h2>Pergerakan Stok</h2>

                <span id="movementCount">
                    {{ $movements->count() }} Data Pergerakan Stok
                </span>

            </div>

            {{-- SEARCH + TANGGAL --}}
            <div class="toolbar">

                {{-- SEARCH LIVE --}}
                <input
                    type="text"
                    id="searchMovement"
                    class="search-box"
                    placeholder="Cari Produk"
                    value="{{ request('search') }}"
                >

                {{-- FILTER PRODUK --}}
                <div class="product-filter">

                    <button
                        type="button"
                        class="product-filter-btn"
                        id="productFilterButton">

                        <span id="selectedProductText">

                            @if(request('product_id'))

                                {{ optional(
                                    $products->firstWhere(
                                        'id',
                                        request('product_id')
                                    )
                                )->nama_produk ?? 'Pilih Produk' }}

                            @else

                                Semua Produk

                            @endif

                        </span>

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>


                    <div
                        class="product-filter-dropdown"
                        id="productFilterDropdown">

                        {{-- SEARCH DI DALAM DROPDOWN --}}

                        <div class="product-search-wrapper">

                            <input
                                type="text"
                                id="productSearchInput"
                                class="product-search-input"
                                placeholder="Cari produk..."
                                autocomplete="off"
                            >

                        </div>


                        {{-- DAFTAR PRODUK --}}

                        <div class="product-options">

                            <button
                                type="button"
                                class="product-option {{ !request('product_id') ? 'active' : '' }}"
                                data-product-id="">

                                Semua Produk

                            </button>


                            @foreach($products as $product)

                                <button
                                    type="button"
                                    class="product-option {{ request('product_id') == $product->id ? 'active' : '' }}"
                                    data-product-id="{{ $product->id }}">

                                    {{ $product->nama_produk }}

                                </button>

                            @endforeach

                        </div>

                    </div>

                </div>

                {{-- FILTER STATUS --}}
                <div class="status-filter">

                    <button
                        type="button"
                        class="status-filter-btn"
                        id="statusFilterButton">

                        <span id="selectedStatusText">

                            @switch(request('jenis'))

                                @case('Masuk')
                                    Stok Masuk
                                    @break

                                @case('Keluar')
                                    Penjualan
                                    @break

                                @case('retur')
                                    Retur
                                    @break

                                @case('Opname')
                                    Opname
                                    @break

                                @default
                                    Semua Status

                            @endswitch

                        </span>

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>


                    <div
                        class="status-filter-dropdown"
                        id="statusFilterDropdown">

                        <button
                            type="button"
                            class="status-option"
                            data-jenis="">

                            Semua Status

                        </button>

                        <button
                            type="button"
                            class="status-option"
                            data-jenis="Masuk">

                            Stok Masuk

                        </button>

                        <button
                            type="button"
                            class="status-option"
                            data-jenis="Keluar">

                            Penjualan

                        </button>

                        <button
                            type="button"
                            class="status-option"
                            data-jenis="retur">

                            Retur

                        </button>

                        <button
                            type="button"
                            class="status-option"
                            data-jenis="Opname">

                            Opname

                        </button>

                    </div>

                </div>

                {{-- FILTER TANGGAL --}}
                <div class="date-toolbar">

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
                                    {{ request('tanggal') }}
                                    @break

                                @default
                                    Semua Tanggal

                            @endswitch

                        </span>

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>

                    {{-- DROPDOWN --}}
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

                        <hr>

                        <button
                            type="button"
                            class="date-option"
                            id="customDate">

                            Pilih Tanggal...

                        </button>

                    </div>

                </div>

            </div>

        </div>

        {{-- JUMLAH BARIS --}}
        <div class="rows-toolbar">

            <select
                id="perPage"
                class="rows-select">

                <option value="10">10 Baris</option>

                <option value="25">25 Baris</option>

                <option value="50">50 Baris</option>

            </select>

        </div>

    </div>

    <div class="page-body">

        <div class="table-wrapper">

            <table class="stock-table">

                <thead>

                    <tr>

                        <th>Tanggal</th>

                        <th>Produk</th>

                        <th>Status</th>

                        <th>Qty</th>

                        <th>Stok Awal</th>

                        <th>Stok Akhir</th>

                        <th>Keterangan</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($movements as $item)

                    <tr>

                        <td>
                            {{ date('d-m-Y', strtotime($item->tanggal)) }}
                        </td>

                        <td>
                            {{ optional($item->product)->nama_produk ?? '-' }}
                        </td>

                        <td>

                            @switch(strtolower($item->jenis))

                                @case('masuk')

                                    <span class="badge-masuk">
                                        Stok Masuk
                                    </span>

                                    @break

                                @case('keluar')

                                    <span class="badge-keluar">
                                        Penjualan
                                    </span>

                                    @break

                                @case('retur')

                                    <span class="badge-masuk">
                                        Retur
                                    </span>

                                    @break

                                @case('opname')

                                    <span class="badge-opname">
                                        Opname
                                    </span>

                                    @break

                                @default

                                    <span class="badge bg-secondary">
                                        {{ ucfirst($item->jenis) }}
                                    </span>

                            @endswitch

                        </td>

                        <td>{{ $item->qty }}</td>

                        <td>{{ $item->stok_awal }}</td>

                        <td>{{ $item->stok_akhir }}</td>

                        <td>{{ $item->keterangan }}</td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">
                            Belum ada data
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- ==========================================================
     MODAL PILIH TANGGAL
========================================================== --}}

<div
    class="date-modal-overlay"
    id="dateModal">

    <div class="date-modal">

        <div class="date-modal-header">

            <h3 style="margin:0;">

                <i class="fa-regular fa-calendar"></i>

                Pilih Tanggal

            </h3>

        </div>

        <div class="date-modal-body">

            <input
                type="date"
                id="selectedDateInput"
                class="date-input">

        </div>

        <div class="date-modal-footer">

            <button
                type="button"
                class="btn-cancel-modal"
                id="closeDateModal">

                Batal

            </button>

            <button
                type="button"
                class="btn-confirm"
                id="saveDateFilter">

                Simpan

            </button>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

document.addEventListener("DOMContentLoaded", function () {

    /* ==========================================================
       ELEMENT
    ========================================================== */

    const searchInput =
        document.getElementById("searchMovement");

    const dateButton =
        document.getElementById("dateFilterButton");

    const dateDropdown =
        document.getElementById("dateFilterDropdown");

    const customDate =
        document.getElementById("customDate");

    const dateModal =
        document.getElementById("dateModal");

    const closeDateModal =
        document.getElementById("closeDateModal");

    const saveDateFilter =
        document.getElementById("saveDateFilter");

    const selectedDateInput =
        document.getElementById("selectedDateInput");

    const selectedFilterText =
        document.getElementById("selectedFilterText");

    const perPage =
        document.getElementById("perPage");

    /* ==========================================================
    DROPDOWN PRODUK
    ========================================================== */

    const productFilter =
        document.querySelector(".product-filter");

    const productFilterButton =
        document.getElementById("productFilterButton");

    const productFilterDropdown =
        document.getElementById("productFilterDropdown");

    const productSearchInput =
        document.getElementById("productSearchInput");

    const selectedProductText =
        document.getElementById("selectedProductText");

    const productOptions =
        document.querySelectorAll(".product-option");


    /* ==========================================================
    BUKA / TUTUP DROPDOWN PRODUK
    ========================================================== */

    if (
        productFilter &&
        productFilterButton &&
        productFilterDropdown
    ) {

        productFilterButton.addEventListener(
            "click",
            function(e){

                e.stopPropagation();

                productFilterDropdown.classList.toggle(
                    "show"
                );

                productFilter.classList.toggle(
                    "active"
                );

                if (
                    productFilterDropdown.classList.contains(
                        "show"
                    )
                ){

                    productSearchInput.focus();

                }

            }
        );


        /* ======================================================
        SEARCH PRODUK DI DALAM DROPDOWN
        ====================================================== */

        productSearchInput.addEventListener(
            "input",
            function(){

                const keyword =
                    this.value
                        .toLowerCase()
                        .trim();


                productOptions.forEach(
                    function(option){

                        const productName =
                            option.textContent
                                .trim()
                                .toLowerCase();


                        if (
                            productName.includes(
                                keyword
                            )
                        ){

                            option.style.display =
                                "block";

                        }else{

                            option.style.display =
                                "none";

                        }

                    }
                );

            }
        );


        /* ======================================================
        PILIH PRODUK
        ====================================================== */

        productOptions.forEach(
            function(option){

                option.addEventListener(
                    "click",
                    function(){

                        const productId =
                            this.dataset.productId;


                        const url =
                            new URL(
                                window.location.href
                            );


                        if(productId){

                            url.searchParams.set(
                                "product_id",
                                productId
                            );

                        }else{

                            url.searchParams.delete(
                                "product_id"
                            );

                        }


                        /*
                        * Kembali ke halaman pertama
                        */

                        url.searchParams.delete(
                            "page"
                        );


                        window.location.href =
                            url.toString();

                    }
                );

            }
        );

    }


    /* ==========================================================
    TUTUP DROPDOWN PRODUK KETIKA KLIK DI LUAR
    ========================================================== */

    document.addEventListener(
        "click",
        function(e){

            if(
                productFilter &&
                !e.target.closest(
                    ".product-filter"
                )
            ){

                productFilterDropdown.classList.remove(
                    "show"
                );

                productFilter.classList.remove(
                    "active"
                );

            }

        }
    );

    /* ==========================================================
       DROPDOWN STATUS
    ========================================================== */

    const statusFilter =
        document.querySelector(".status-filter");

    const statusFilterButton =
        document.getElementById("statusFilterButton");

    const statusFilterDropdown =
        document.getElementById("statusFilterDropdown");


    if (
        statusFilter &&
        statusFilterButton &&
        statusFilterDropdown
    ) {

        statusFilterButton.addEventListener(
            "click",
            function (e) {

                e.stopPropagation();

                statusFilterDropdown.classList.toggle(
                    "show"
                );

                statusFilter.classList.toggle(
                    "active"
                );

            }
        );


        document
            .querySelectorAll(".status-option")
            .forEach(function (option) {

                option.addEventListener(
                    "click",
                    function () {

                        const jenis =
                            this.dataset.jenis;

                        const url =
                            new URL(window.location.href);


                        if (jenis === "") {

                            url.searchParams.delete(
                                "jenis"
                            );

                        } else {

                            url.searchParams.set(
                                "jenis",
                                jenis
                            );

                        }


                        /*
                         * Kembali ke halaman pertama
                         */

                        url.searchParams.delete(
                            "page"
                        );


                        window.location.href =
                            url.toString();

                    }
                );

            });

    }


    /* ==========================================================
       DROPDOWN TANGGAL
    ========================================================== */

    dateButton.addEventListener("click", function (e) {

        e.stopPropagation();

        dateDropdown.classList.toggle("show");

    });


    /* ==========================================================
       TUTUP DROPDOWN JIKA KLIK DI LUAR
    ========================================================== */

    document.addEventListener("click", function (e) {

        if (!e.target.closest(".date-toolbar")) {

            dateDropdown.classList.remove("show");

        }

    });

    document.addEventListener(
        "click",
        function (e) {

            if (
                statusFilter &&
                !e.target.closest(".status-filter")
            ) {

                statusFilterDropdown.classList.remove(
                    "show"
                );

                statusFilter.classList.remove(
                    "active"
                );

            }

        }
    );


    /* ==========================================================
       PILIH FILTER TANGGAL
    ========================================================== */

    document
        .querySelectorAll(".date-option")
        .forEach(function (option) {

            option.addEventListener("click", function () {

                const filter =
                    this.dataset.filter;

                if (!filter) {
                    return;
                }

                if (filter === "custom") {
                    return;
                }

                const url =
                    new URL(window.location);

                if (filter === "all") {

                    url.searchParams.delete("filter");
                    url.searchParams.delete("tanggal");

                } else {

                    url.searchParams.set(
                        "filter",
                        filter
                    );

                    url.searchParams.delete(
                        "tanggal"
                    );

                }

                /*
                 * Pertahankan search
                 */

                const search =
                    searchInput.value.trim();

                if (search) {

                    url.searchParams.set(
                        "search",
                        search
                    );

                } else {

                    url.searchParams.delete(
                        "search"
                    );

                }

                window.location.href =
                    url.toString();

            });

        });


    /* ==========================================================
       PILIH TANGGAL CUSTOM
    ========================================================== */

    customDate.addEventListener("click", function () {

        dateDropdown.classList.remove("show");

        dateModal.classList.add("show");

    });


    /* ==========================================================
       TUTUP MODAL
    ========================================================== */

    closeDateModal.addEventListener(
        "click",
        function () {

            dateModal.classList.remove("show");

        }
    );


    dateModal.addEventListener(
        "click",
        function (e) {

            if (e.target === dateModal) {

                dateModal.classList.remove(
                    "show"
                );

            }

        }
    );


    /* ==========================================================
       SIMPAN TANGGAL CUSTOM
    ========================================================== */

    saveDateFilter.addEventListener(
        "click",
        function () {

            const tanggal =
                selectedDateInput.value;

            if (!tanggal) {

                alert(
                    "Silakan pilih tanggal terlebih dahulu."
                );

                return;

            }

            const url =
                new URL(window.location);

            url.searchParams.set(
                "filter",
                "custom"
            );

            url.searchParams.set(
                "tanggal",
                tanggal
            );

            const search =
                searchInput.value.trim();

            if (search) {

                url.searchParams.set(
                    "search",
                    search
                );

            }

            window.location.href =
                url.toString();

        }
    );


    /* ==========================================================
       LIVE SEARCH
    ========================================================== */

    let searchTimer;

    searchInput.addEventListener(
        "input",
        function () {

            clearTimeout(searchTimer);

            searchTimer = setTimeout(
                function () {

                    filterTable();

                },
                200
            );

        }
    );


    /* ==========================================================
       FILTER TABEL
    ========================================================== */

    function filterTable() {

        const keyword =
            searchInput.value
                .toLowerCase()
                .trim();

        const rows =
            document.querySelectorAll(
                ".stock-table tbody tr"
            );

        let visibleCount = 0;

        rows.forEach(function (row) {

            /*
             * Lewati baris "Belum ada data"
             */

            if (
                row.querySelector(
                    ".no-data"
                )
            ) {
                return;
            }

            const rowText =
                row.innerText
                    .toLowerCase();

            if (
                keyword === "" ||
                rowText.includes(keyword)
            ) {

                row.style.display = "";

                visibleCount++;

            } else {

                row.style.display = "none";

            }

        });


        /*
         * Update jumlah hasil pencarian
         */

        document.getElementById(
            "movementCount"
        ).innerText =
            visibleCount +
            " Data Pergerakan Stok";

    }


    /* ==========================================================
       JUMLAH BARIS
    ========================================================== */

    perPage.addEventListener(
        "change",
        function () {

            applyPerPage();

        }
    );


    function applyPerPage() {

        const limit =
            parseInt(perPage.value);

        const rows =
            Array.from(
                document.querySelectorAll(
                    ".stock-table tbody tr"
                )
            );

        let shown = 0;

        rows.forEach(function (row) {

            if (
                row.querySelector(
                    ".no-data"
                )
            ) {
                return;
            }

            /*
             * Jangan tampilkan lebih dari limit
             */

            if (shown < limit) {

                row.style.display = "";

                shown++;

            } else {

                row.style.display = "none";

            }

        });

    }


    /* ==========================================================
       JALANKAN SAAT HALAMAN DIBUKA
    ========================================================== */

    filterTable();

    applyPerPage();

});

</script>

@endsection