@extends('layouts.admin')

@section('title', 'Retur')

@section('content')

<style>

/* ==========================================================
   PAGE LAYOUT
========================================================== */

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

/* ==========================================================
   PAGE HEADER
========================================================== */

.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

/* ==========================================================
   FILTER AREA
========================================================== */

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

    align-items:flex-start;

}

.stock-info h2{
    margin:0;
    font-size:18px;
}

.stock-info span{
    color:#999;
}

.toolbar{

    position:relative;

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

}

.date-filter-dropdown{

    position:absolute;

    margin-top:8px;

    width:230px;

    background:#fff;

    border:1px solid #ddd;

    border-radius:10px;

    box-shadow:0 8px 25px rgba(0,0,0,.08);

    display:none;

    overflow:hidden;

    z-index:100;

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

}

.date-option:hover{

    background:#f4f6fb;

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

.filter-form{

    display:flex;

    align-items:center;

    gap:15px;

}

.search-box{

    width:320px;

    height:46px;

    padding:0 15px;

    border:1px solid #ddd;

    border-radius:10px;

}

.filter-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
    height:46px;
    width:180px;
}

/* ==========================================================
   TABLE
========================================================== */

.table-section{
    padding:15px 25px 25px;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
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

.no-data{
    text-align:center;
    color:#999;
    padding:40px;
}


.transaction-table{

    width:100%;

    border-collapse:collapse;

    min-width:1200px;

}

.transaction-table th,
.transaction-table td{

    white-space:nowrap;

}

.transaction-table thead{

    background:#f4f6fb;

}

.transaction-table th{

    padding:17px 18px;

    text-align:left;

    font-size:14px;

    font-weight:700;

    color:#444;

}

.transaction-table td{

    padding:18px;

    border-top:1px solid #edf0f5;

    font-size:14px;

    color:#555;

}

.transaction-table tbody tr:hover{

    background:#fafcff;

}

/* ==========================================================
   STATUS
========================================================== */

.status-badge{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    min-width:90px;

    padding:6px 14px;

    border-radius:20px;

    font-size:13px;

    font-weight:600;

}

.status-badge.success{

    background:#e8f8ef;

    color:#1b8f4b;

}

/* ==========================================================
   BUTTON
========================================================== */

.btn-detail{

    background:#355cc9;

    color:white;

    border:none;

    border-radius:10px;

    padding:8px 18px;

    font-size:13px;

    cursor:pointer;

    transition:.2s;

    text-decoration:none;

    display:inline-flex;

    align-items:center;

    justify-content:center;

}

.btn-detail:hover{ 

    background:#284db5;

}

.btn-detail i{

    margin-right:6px;

}

.btn-delete {
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 8px 14px;
    font-size: 13px;
    cursor: pointer;
    transition: .2s;
    margin-left: 6px;
}

.btn-delete:hover {
    background: #dc2626;
}

/* ==========================================================
   DATE MODAL
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

/* ==========================================================
   PAGINATION
========================================================== */

#paginationContainer{

    margin-left:auto;

    display:flex;

    align-items:center;

    gap:4px;

}

.pagination-btn{

    border:none;

    background:transparent;

    color:#6b7280;

    cursor:pointer;

    font-size:14px;

    font-weight:500;

    padding:4px 6px;

    transition:.2s;

}

.pagination-btn:hover{

    color:#355cc9;

}

.pagination-btn.active{

    color:#355cc9;

    font-weight:700;

}

.pagination-btn:disabled{

    color:#cbd5e1;

    cursor:default;

}

.pagination-ellipsis{

    display:inline-flex;

    align-items:center;

    padding:0 6px;

    color:#999;

    font-size:14px;

}

</style>

<div class="page-header">

    {{-- HEADER BIRU --}}
    <div class="top-header">

        Transaksi

    </div>

    {{-- FILTER --}}
    <div class="filter-section">

        <div class="filter-top">

            <div class="stock-info">

                <h2>Daftar Retur</h2>

                <span>

                    {{ $returns->total() }} Data Retur

                </span>

            </div>
            
            <div class="toolbar">

                <button
                    type="button"
                    class="date-filter-btn"
                    id="dateFilterButton">

                    <i class="fa-regular fa-calendar"></i>

                    <span id="selectedFilterText">

                        @switch($filter)

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

        <div class="filter-bottom">

            <div class="filter-right">

                <form
                    id="filterForm"
                    method="GET"
                    action="{{ route('admin.transaksi.retur') }}"
                    class="filter-form">

                    {{-- Filter Tanggal --}}
                    <input
                        type="hidden"
                        name="filter"
                        value="{{ request('filter','all') }}">

                    <input
                        type="hidden"
                        name="tanggal"
                        value="{{ request('tanggal') }}">

                    {{-- Filter Kasir --}}
                    <select
                        id="kasirFilter"
                        name="kasir"
                        class="filter-box">

                        <option value="">
                            Semua Kasir
                        </option>

                        @foreach($cashiers as $cashier)

                            <option
                                value="{{ $cashier->id }}"
                                {{ request('kasir') == $cashier->id ? 'selected' : '' }}>

                                {{ $cashier->name }}

                            </option>

                        @endforeach

                    </select>

                    {{-- Search Kode --}}
                    <input
                        id="searchKode"
                        type="text"
                        name="kode"
                        class="search-box"
                        placeholder="Cari Kode Retur"
                        value="{{ request('kode') }}">

                </form>

            </div>

        </div>

    </div>

    {{-- TABEL --}}
    <div class="table-section">

        <div class="table-wrapper">

            <table class="transaction-table">

                <thead>

                    <tr>

                        <th>Tanggal</th>

                        <th>Kode Retur</th>

                        <th>Kode Penjualan</th>

                        <th>Kasir</th>

                        <th>Jenis Retur</th>

                        <th>Total Retur</th>

                        <th>Nilai Pengganti</th>

                        <th>Status Pembayaran</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody id="returnsTableBody">

                    @forelse($returns as $return)

                        <tr>

                            {{-- Tanggal --}}
                            <td>

                                {{ \Carbon\Carbon::parse($return->tanggal)->translatedFormat('d F Y') }}

                            </td>

                            {{-- Kode Retur --}}
                            <td>

                                {{ $return->kode_retur }}

                            </td>

                            {{-- Kode Penjualan --}}
                            <td>

                                {{ $return->sale->kode_penjualan }}

                            </td>

                            {{-- Kasir --}}
                            <td>

                                {{ $return->user->name }}

                            </td>

                            {{-- Jenis Retur --}}
                            <td>

                                @if($return->return_type === 'uang')

                                    <span class="status-badge success">

                                        Retur Uang

                                    </span>

                                @else

                                    <span class="status-badge success">

                                        Tukar Barang

                                    </span>

                                @endif

                            </td>

                            {{-- Total Retur --}}
                            <td>

                                Rp {{ number_format($return->total_retur,0,',','.') }}

                            </td>

                            {{-- Nilai Pengganti --}}
                            <td>

                                @if($return->return_type === 'tukar')

                                    Rp {{ number_format($return->total_pengganti,0,',','.') }}

                                @else

                                    -

                                @endif

                            </td>

                            {{-- Status Pembayaran --}}
                            <td>

                                @if($return->return_type === 'uang')

                                    <span class="status-badge success">

                                        Uang Dikembalikan

                                    </span>

                                @elseif($return->selisih_bayar > 0)

                                    <span class="status-badge success">

                                        Selisih Dibayar

                                        Rp {{ number_format($return->selisih_bayar,0,',','.') }}

                                    </span>

                                @else

                                    <span class="status-badge success">

                                        Tidak Ada Pembayaran

                                    </span>

                                @endif

                            </td>

                            {{-- Aksi --}}
                            <td>

                                {{-- DETAIL --}}
                                <a
                                    href="{{ route('admin.transaksi.retur.show', $return) }}"
                                    class="btn-detail">

                                    <i class="fa-solid fa-eye"></i>

                                    Detail

                                </a>


                                {{-- HAPUS --}}
                                <form
                                    action="{{ route('admin.transaksi.retur.destroy', $return) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus retur {{ $return->kode_retur }}?');">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn-delete">

                                        <i class="fa-solid fa-trash"></i>

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="no-data">

                                Belum ada transaksi retur.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="table-footer">

            <div class="footer-left">

                <select
                    id="perPage"
                    class="filter-box">

                    <option
                        value="10"
                        {{ request('per_page',10)==10 ? 'selected' : '' }}>

                        10/page

                    </option>

                    <option
                        value="25"
                        {{ request('per_page')==25 ? 'selected' : '' }}>

                        25/page

                    </option>

                    <option
                        value="50"
                        {{ request('per_page')==50 ? 'selected' : '' }}>

                        50/page

                    </option>

                </select>

                <span id="totalData">

                    Total {{ $returns->total() }} Data

                </span>

            </div>

            <div id="paginationContainer"></div>

        </div>

    </div>

</div>

{{-- ==========================================================
     MODAL PILIH TANGGAL
========================================================== --}}

<div class="date-modal-overlay" id="dateModal">

    <div class="date-modal">

        <div class="date-modal-header">

            <h5>

                <i class="fa-regular fa-calendar"></i>

                Pilih Tanggal

            </h5>

        </div>

        <div class="date-modal-body">

            <input
                type="date"
                id="selectedDateInput"
                class="filter-box"
                style="width:100%;">

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

document.addEventListener("click", function(){

    dropdown.classList.remove("show");

});

customDate.addEventListener("click", function(){

    dropdown.classList.remove("show");

    dateModal.classList.add("show");

});

closeDateModal.addEventListener("click", function(){

    dateModal.classList.remove("show");

});

dateModal.addEventListener("click", function(e){

    if(e.target === dateModal){

        dateModal.classList.remove("show");

    }

});

const dateOptions =
    document.querySelectorAll(".date-option");

dateOptions.forEach(function(option){

    option.addEventListener("click", function(){

        const filter = this.dataset.filter;

        if(!filter) return;

        document.querySelector('input[name="filter"]').value = filter;

        document.querySelector('input[name="tanggal"]').value = "";

        document.getElementById("selectedFilterText").innerText =
            this.innerText;

        dropdown.classList.remove("show");

        fetchData();

    });

});

const saveDateFilter =
    document.getElementById("saveDateFilter");

saveDateFilter.addEventListener("click", function(){

    const tanggal =
        document.getElementById("selectedDateInput").value;

    if(!tanggal){

        alert("Silakan pilih tanggal.");

        return;

    }

    document.querySelector('input[name="filter"]').value = "custom";

    document.querySelector('input[name="tanggal"]').value = tanggal;

    document.getElementById("selectedFilterText").innerText = tanggal;

    dateModal.classList.remove("show");

    fetchData();

});

// Filter Kasir otomatis
document.getElementById("kasirFilter")
.addEventListener("change", function () {

    fetchData();

});

let searchTimer;

const searchBox = document.getElementById("searchKode");

searchBox.addEventListener("input", function () {

    clearTimeout(searchTimer);

    searchTimer = setTimeout(() => {

        fetchData();

    }, 300);

});

function formatTanggal(tanggal){

    const date = new Date(tanggal);

    return date.toLocaleDateString("id-ID");

}

function renderReturnRow(returnSale)
{
    let jenisRetur = "";

    let nilaiPengganti = "-";

    let statusPembayaran = "";


    /*
    |--------------------------------------------------------------------------
    | JENIS RETUR
    |--------------------------------------------------------------------------
    */

    if(returnSale.return_type === "uang"){

        jenisRetur = `
            <span class="status-badge success">
                Retur Uang
            </span>
        `;

    }else{

        jenisRetur = `
            <span class="status-badge success">
                Tukar Barang
            </span>
        `;

    }


    /*
    |--------------------------------------------------------------------------
    | NILAI PENGGANTI
    |--------------------------------------------------------------------------
    */

    if(returnSale.return_type === "tukar"){

        nilaiPengganti =
            "Rp " +
            Number(returnSale.total_pengganti)
            .toLocaleString("id-ID");

    }


    /*
    |--------------------------------------------------------------------------
    | STATUS PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    if(returnSale.return_type === "uang"){

        statusPembayaran = `
            <span class="status-badge success">
                Uang Dikembalikan
            </span>
        `;

    }
    else if(Number(returnSale.selisih_bayar) > 0){

        statusPembayaran = `
            <span class="status-badge success">
                Selisih Dibayar
                Rp ${Number(returnSale.selisih_bayar)
                    .toLocaleString("id-ID")}
            </span>
        `;

    }
    else{

        statusPembayaran = `
            <span class="status-badge success">
                Tidak Ada Pembayaran
            </span>
        `;

    }


    /*
    |--------------------------------------------------------------------------
    | ROW
    |--------------------------------------------------------------------------
    */

    return `
        <tr>

            <td>

                ${formatTanggal(returnSale.tanggal)}

            </td>

            <td>

                ${returnSale.kode_retur}

            </td>

            <td>

                ${returnSale.sale
                    ? returnSale.sale.kode_penjualan
                    : "-"}

            </td>

            <td>

                ${returnSale.user
                    ? returnSale.user.name
                    : "-"}

            </td>

            <td>

                ${jenisRetur}

            </td>

            <td>

                Rp ${Number(returnSale.total_retur)
                    .toLocaleString("id-ID")}

            </td>

            <td>

                ${nilaiPengganti}

            </td>

            <td>

                ${statusPembayaran}

            </td>

            <td>

                <a
                    href="/admin/transaksi/retur/${returnSale.id}"
                    class="btn-detail">

                    <i class="fa-solid fa-eye"></i>

                    Detail

                </a>

            </td>

        </tr>
    `;
}

function renderPagination(data)
{
    if (data.last_page <= 1) {

        document.getElementById("paginationContainer").innerHTML = "";

        return;
    }

    let html = "";

    // Tombol Previous
   html += `
    <button
        class="pagination-btn"
        ${data.current_page == 1 ? 'disabled' : ''}
        onclick="${data.current_page > 1 ? `fetchData(${data.current_page - 1})` : ''}">

        &laquo;

    </button>
    `;

    // ================================
    // Nomor Halaman ala Laravel
    // ================================

    let start = Math.max(1, data.current_page - 2);

    let end = Math.min(data.last_page, data.current_page + 2);

    // Halaman pertama
    if(start > 1){

        html += `
            <button
                class="pagination-btn"
                onclick="fetchData(1)">

                1

            </button>
        `;

        if(start > 2){

            html += `<span class="pagination-ellipsis">...</span>`;

        }

    }

    // Halaman tengah
    for(let i = start; i <= end; i++){

        html += `
            <button
                class="pagination-btn ${i == data.current_page ? 'active' : ''}"
                onclick="fetchData(${i})">

                ${i}

            </button>
        `;

    }

    // Halaman terakhir
    if(end < data.last_page){

        if(end < data.last_page - 1){

            html += `<span class="pagination-ellipsis">...</span>`;

        }

        html += `
            <button
                class="pagination-btn"
                onclick="fetchData(${data.last_page})">

                ${data.last_page}

            </button>
        `;

    }

    // Tombol Next
    html += `
    <button
        class="pagination-btn"
        ${data.current_page == data.last_page ? 'disabled' : ''}
        onclick="${data.current_page < data.last_page ? `fetchData(${data.current_page + 1})` : ''}">

        &raquo;

    </button>
    `;

    document.getElementById("paginationContainer").innerHTML = html;

    document.getElementById("totalData").innerText =
        `Total ${data.total} Data`;
}

function fetchData(page = 1)
{
    const kode = document.getElementById("searchKode").value;

    const kasir = document.getElementById("kasirFilter").value;

    const filter = document.querySelector('input[name="filter"]').value;

    const tanggal = document.querySelector('input[name="tanggal"]').value;

    const perPage = document.getElementById("perPage").value;

    const params = new URLSearchParams({

        kode: kode,

        kasir: kasir,

        filter: filter,

        tanggal: tanggal,

        per_page: perPage,

        page: page

    });

    const url = new URL(window.location);

    url.searchParams.set("page", page);

    url.searchParams.set("per_page", perPage);

    if (kode) {

        url.searchParams.set("kode", kode);

    } else {

        url.searchParams.delete("kode");

    }

    if (kasir) {

        url.searchParams.set("kasir", kasir);

    } else {

        url.searchParams.delete("kasir");

    }

    if (filter !== "all") {

        url.searchParams.set("filter", filter);

    } else {

        url.searchParams.delete("filter");

    }

    if (tanggal) {

        url.searchParams.set("tanggal", tanggal);

    } else {

        url.searchParams.delete("tanggal");

    }

history.replaceState({}, "", url);

    fetch(`{{ route('admin.transaksi.retur.search') }}?${params.toString()}`)

        .then(response => response.json())

        .then(data => {

            let rows = "";

            if (data.data.length === 0) {

                rows = `
                    <tr>
                        <td colspan="9" class="no-data">
                            Belum ada transaksi retur.
                        </td>
                    </tr>
                `;

            } else {

                data.data.forEach(function(returnSale){

                    rows += renderReturnRow(returnSale);

                });

            }

            document.getElementById("returnsTableBody").innerHTML = rows;

            renderPagination(data);

        })

        .catch(error => console.error(error));

}

document
.getElementById("perPage")
.addEventListener("change", function () {

    fetchData(1);

});

// fetchData(
//     {{ $returns->currentPage() }}
// );

</script>

@endsection