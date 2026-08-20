@extends('layouts.admin')

@section('title', 'Stok Masuk')

@section('content')

<style>

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

/* HEADER */
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
    flex-wrap:wrap;
    gap:15px;
}

.filter-top{
    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:20px;
}

.stock-info h2{
    margin:0;
    font-size:18px;
}

.stock-info span{
    color:#999;
}

.toolbar{
    display:flex;
    align-items:center;
    gap:15px;
}

.date-filter-wrapper{
    position:relative;
}

.filter-form{
    display:flex;
    align-items:center;
    gap:15px;
}

.search-box{
    width:260px;
    height:46px;
    padding:0 15px;
    border:1px solid #ddd;
    border-radius:10px;
    box-sizing:border-box;
    outline:none;
    font-size:14px;
}

.search-box:focus{
    border-color:#1684e0;
}

.filter-bottom{
    width:100%;
    margin-top:18px;
}

.filter-right{
    width:100%;
    display:flex;
    justify-content:flex-end;
}

.date-filter-btn{

    min-width:230px;

    height:46px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:0 16px;

    background:#fff;

    border:1px solid #ddd;

    border-radius:10px;

    cursor:pointer;

    font-size:14px;

    color:#333;

}

.date-filter-btn:hover{
    border-color:#1684e0;
}

.date-filter-dropdown{

    position:absolute;

    top:54px;

    left:0;

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

    border:none;

    background:white;

    text-align:left;

    padding:12px 16px;

    cursor:pointer;

    font-size:14px;

    color:#333;

}

.date-option:hover{
    background:#f4f6fb;
}

.date-option hr{
    margin:0;
}

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

    font-weight:600;

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

.btn-cancel-modal{

    border:none;

    background:#eee;

    color:#333;

    padding:10px 18px;

    border-radius:8px;

    cursor:pointer;

}

.btn-confirm{

    border:none;

    background:#1684e0;

    color:white;

    padding:10px 18px;

    border-radius:8px;

    cursor:pointer;

}

.date-text{
    display:flex;
    align-items:center;
    gap:10px;

    font-weight:600;
}

.btn-primary{
    background:#1684e0;
}

.btn-primary i{
    margin-right:8px;
}

.filter-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.btn{
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    color:white;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
}

.btn-primary{
    background:#1684e0;
    text-decoration:none;
}

.btn-primary:hover{
    background:#1478ca;
    text-decoration:none;
}

/* TABLE */
.table-section{
    padding:25px;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
}

.stock-table{
    width:100%;
    min-width:1100px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f3f5fa;
    padding:12px;
    text-align:left;
    font-size:14px;
    font-weight:600;
}

table td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.no-data{
    text-align:center;
    color:#999;
    padding:40px;
}

/* DATE RANGE PICKER */
.daterangepicker .ranges li{
    padding:10px 15px;
}

.daterangepicker .ranges li.active{
    background:#1684e0;
}

.daterangepicker td.active,
.daterangepicker td.active:hover{
    background:#1684e0;
}

.daterangepicker .applyBtn{
    background:#1684e0;
    border-color:#1684e0;
}

.table-footer{
    margin-top:20px;
    display:flex;
    justify-content:flex-start;
    align-items:center;
}

.footer-left{
    display:flex;
    align-items:center;
    gap:15px;
}

.delete-btn{
    border:none;
    background:none;
    cursor:pointer;
    color:#999;
    font-size:20px;
}

.stock-table th,
.stock-table td{
    white-space:nowrap;
}

</style>

<div class="page-header">

    <div class="top-header">
        Inventory
    </div>

    <div class="filter-section">

        <div class="filter-top">

            <div class="stock-info">

                <h2>Daftar Stok Masuk</h2>

                <span>
                    {{ $stockIns->count() }} Stok Masuk
                </span>

            </div>

            <div class="toolbar">

                {{-- DROPDOWN PERIODE --}}

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

                                    {{ request('tanggal') ?: 'Pilih Tanggal' }}

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

                        <hr style="
                            margin:0;
                            border:0;
                            border-top:1px solid #eee;
                        ">

                        <button
                            type="button"
                            class="date-option"
                            id="customDate">

                            Pilih Tanggal...

                        </button>

                    </div>

                </div>


                {{-- SEARCH --}}

                <form
                    id="filterForm"
                    method="GET"
                    action="{{ route('admin.stok-masuk.index') }}"
                    class="filter-form">

                    <input
                        type="hidden"
                        name="filter"
                        id="filterInput"
                        value="{{ request('filter', 'all') }}">

                    <input
                        type="hidden"
                        name="tanggal"
                        id="tanggalInput"
                        value="{{ request('tanggal') }}">

                    <input
                        type="text"
                        id="searchStock"
                        name="search"
                        class="search-box"
                        placeholder="Cari No. Stok Masuk"
                        value="{{ request('search') }}"
                        autocomplete="off">

                </form>


                {{-- TOMBOL TAMBAH --}}

                <a
                    href="{{ route('admin.stok-masuk.create') }}"
                    class="btn btn-primary">

                    Tambah

                </a>

            </div>

        </div>

        <div class="filter-bottom">

            <select class="filter-box">

                <option>10 Baris</option>
                <option>25 Baris</option>
                <option>50 Baris</option>

            </select>

        </div>

    </div>

    <form id="bulkDeleteForm"
        action="{{ route('admin.stok-masuk.bulkDelete') }}"
        method="POST">

        @csrf
        @method('DELETE')

        <input type="hidden"
            name="ids"
            id="selectedIds">

    </form>

    <div class="table-section">

        <div class="table-wrapper">

            <table class="stock-table">

            <thead>

                <tr>
                    
                <th width="40">
                    <input type="checkbox" id="checkAll">
                </th>

                <th width="170">No Transaksi</th>

                <th width="120">Tanggal Masuk</th>

                <th width="150">Supplier</th>

                <th width="180">Produk</th>

                <th width="140">SKU</th>

                <th width="120">Harga Beli</th>

                <th width="100">Qty Stok</th>

                <th width="140">Total Harga</th>

                <th width="150">Keterangan</th>

                <th width="70">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($stockIns as $stock)

            <tr class="stock-row">

                <td>
                    <input
                        type="checkbox"
                        class="row-checkbox"
                        value="{{ $stock->id }}">
                </td>

                <td
                    class="stock-number"
                    title="{{ $stock->nomor_transaksi }}">

                    {{ $stock->nomor_transaksi }}

                </td>

                <td>
                    {{ date('d-m-Y', strtotime($stock->tanggal_masuk)) }}
                </td>

                <td>
                    {{ $stock->supplier->nama_supplier ?? '-' }}
                </td>

                <td>
                    {{ $stock->product->nama_produk ?? '-' }}
                </td>

                <td>
                    {{ $stock->product->sku ?? '-' }}
                </td>

                <td>
                    Rp {{ number_format($stock->harga_beli,0,',','.') }}
                </td>

                <td>
                    {{ $stock->jumlah_masuk }}
                </td>

                <td>
                    Rp {{ number_format($stock->jumlah_masuk * $stock->harga_beli,0,',','.') }}
                </td>

                <td>{{ $stock->keterangan }}</td>

                <td>
                    <a href="{{ route('admin.stok-masuk.edit',$stock->id) }}">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="11" class="no-data">
                    Belum ada data stok masuk
                </td>
            </tr>

            @endforelse

            </tbody>

            </table>

        </div>

        <div class="table-footer">

            <div class="footer-left">

                <button
                    type="button"
                    class="delete-btn"
                    onclick="bulkDelete()">

                    <i class="fa-regular fa-trash-can"></i>

                </button>

                <select class="filter-box">
                    <option>10/page</option>
                    <option>25/page</option>
                    <option>50/page</option>
                </select>

                <span>Total {{ $stockIns->count() }}</span>

            </div>

        </div>

    </div>

</div>

{{-- MODAL PILIH TANGGAL --}}

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
                class="filter-box"
                style="width:100%; box-sizing:border-box;">

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

/* ==========================================================
   DROPDOWN PERIODE
========================================================== */

const dateButton =
    document.getElementById("dateFilterButton");

const dropdown =
    document.getElementById("dateFilterDropdown");

const customDate =
    document.getElementById("customDate");

const dateModal =
    document.getElementById("dateModal");

const closeDateModal =
    document.getElementById("closeDateModal");


dateButton.addEventListener("click", function(e){

    e.stopPropagation();

    dropdown.classList.toggle("show");

});


/* ==========================================================
   TUTUP DROPDOWN KETIKA KLIK DI LUAR
========================================================== */

document.addEventListener("click", function(e){

    if (!e.target.closest(".toolbar")) {

        dropdown.classList.remove("show");

    }

});


/* ==========================================================
   PILIH TANGGAL CUSTOM
========================================================== */

customDate.addEventListener("click", function(){

    dropdown.classList.remove("show");

    dateModal.classList.add("show");

});


/* ==========================================================
   TUTUP MODAL
========================================================== */

closeDateModal.addEventListener("click", function(){

    dateModal.classList.remove("show");

});


dateModal.addEventListener("click", function(e){

    if(e.target === dateModal){

        dateModal.classList.remove("show");

    }

});


/* ==========================================================
   FILTER PERIODE
========================================================== */

const dateOptions =
    document.querySelectorAll(".date-option");


dateOptions.forEach(function(option){

    option.addEventListener("click", function(){

        const filter =
            this.dataset.filter;

        if(!filter){

            return;

        }


        document.getElementById(
            "filterInput"
        ).value = filter;


        document.getElementById(
            "tanggalInput"
        ).value = "";


        document.getElementById(
            "selectedFilterText"
        ).innerText = this.innerText.trim();


        dropdown.classList.remove("show");


        applyDateFilter(filter);

    });

});


/* ==========================================================
   TERAPKAN FILTER TANGGAL
========================================================== */

function applyDateFilter(filter)
{

    const url =
        new URL(
            "{{ route('admin.stok-masuk.index') }}"
        );


    const search =
        document.getElementById(
            "searchStock"
        ).value;


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    if(search){

        url.searchParams.set(
            "search",
            search
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER SEMUA TANGGAL
    |--------------------------------------------------------------------------
    */

    if(filter === "all"){

        url.searchParams.delete(
            "filter"
        );

        url.searchParams.delete(
            "start_date"
        );

        url.searchParams.delete(
            "end_date"
        );

        url.searchParams.delete(
            "tanggal"
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    else{

        url.searchParams.set(
            "filter",
            filter
        );


        const today =
            new Date();


        let startDate;
        let endDate;


        /*
        |--------------------------------------------------------------------------
        | HARI INI
        |--------------------------------------------------------------------------
        */

        if(filter === "today"){

            startDate =
                new Date(today);

            endDate =
                new Date(today);

        }


        /*
        |--------------------------------------------------------------------------
        | KEMARIN
        |--------------------------------------------------------------------------
        */

        else if(filter === "yesterday"){

            startDate =
                new Date(today);

            startDate.setDate(
                today.getDate() - 1
            );

            endDate =
                new Date(startDate);

        }


        /*
        |--------------------------------------------------------------------------
        | 7 HARI TERAKHIR
        |--------------------------------------------------------------------------
        */

        else if(filter === "week"){

            startDate =
                new Date(today);

            startDate.setDate(
                today.getDate() - 6
            );

            endDate =
                new Date(today);

        }


        /*
        |--------------------------------------------------------------------------
        | BULAN INI
        |--------------------------------------------------------------------------
        */

        else if(filter === "month"){

            startDate =
                new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    1
                );

            endDate =
                new Date(
                    today.getFullYear(),
                    today.getMonth() + 1,
                    0
                );

        }


        if(startDate && endDate){

            url.searchParams.set(
                "start_date",
                formatDate(startDate)
            );

            url.searchParams.set(
                "end_date",
                formatDate(endDate)
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | PINDAH HALAMAN
    |--------------------------------------------------------------------------
    */

    window.location.href =
        url.toString();

}


/* ==========================================================
   FORMAT TANGGAL YYYY-MM-DD
========================================================== */

function formatDate(date)
{

    const year =
        date.getFullYear();

    const month =
        String(
            date.getMonth() + 1
        ).padStart(2,"0");

    const day =
        String(
            date.getDate()
        ).padStart(2,"0");


    return `${year}-${month}-${day}`;

}


/* ==========================================================
   SIMPAN TANGGAL CUSTOM
========================================================== */

document
.getElementById("saveDateFilter")
.addEventListener("click", function(){

    const tanggal =
        document.getElementById(
            "selectedDateInput"
        ).value;


    if(!tanggal){

        alert(
            "Silakan pilih tanggal."
        );

        return;

    }


    const url =
        new URL(
            "{{ route('admin.stok-masuk.index') }}"
        );


    /*
    |--------------------------------------------------------------------------
    | FILTER CUSTOM
    |--------------------------------------------------------------------------
    */

    url.searchParams.set(
        "filter",
        "custom"
    );


    url.searchParams.set(
        "tanggal",
        tanggal
    );


    url.searchParams.set(
        "start_date",
        tanggal
    );


    url.searchParams.set(
        "end_date",
        tanggal
    );


    /*
    |--------------------------------------------------------------------------
    | SEARCH TETAP DIPERTAHANKAN
    |--------------------------------------------------------------------------
    */

    const search =
        document.getElementById(
            "searchStock"
        ).value;


    if(search){

        url.searchParams.set(
            "search",
            search
        );

    }


    window.location.href =
        url.toString();

});


/* ==========================================================
   LIVE SEARCH
========================================================== */

const searchStock =
    document.getElementById(
        "searchStock"
    );


const stockRows =
    document.querySelectorAll(
        ".stock-row"
    );


searchStock.addEventListener(
    "input",
    function(){

        const keyword =
            this.value
                .toLowerCase()
                .trim();


        stockRows.forEach(
            function(row){

                const nomorTransaksi =
                    row
                    .querySelector(
                        ".stock-number"
                    )
                    .textContent
                    .toLowerCase();


                if(
                    nomorTransaksi.includes(
                        keyword
                    )
                ){

                    row.style.display = "";

                }else{

                    row.style.display = "none";

                }

            }
        );

    }
);

document.getElementById('checkAll')
?.addEventListener('change', function(){

    document
    .querySelectorAll('.row-checkbox')
    .forEach(item => {

        item.checked = this.checked;

    });

});

function bulkDelete()
{
    let ids = [];

    document
    .querySelectorAll('.row-checkbox:checked')
    .forEach(item => {

        ids.push(item.value);

    });

    if(ids.length === 0)
    {
        alert('Pilih data terlebih dahulu');
        return;
    }

    showConfirm(

        'Hapus Data',

        'Apakah Anda yakin ingin menghapus data yang dipilih?',

        function(){

            document.getElementById('selectedIds').value =
                ids.join(',');

            document
                .getElementById('bulkDeleteForm')
                .submit();

        }

    );
}

</script>

@endsection