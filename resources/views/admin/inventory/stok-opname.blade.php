@extends('layouts.admin')

@section('title', 'Stok Opname')

@section('content')

<style>

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
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

.filter-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.opname-filter-row{
    display:flex;
    align-items:center;
    gap:14px;
    margin-top:30px;
    margin-bottom:30px;
}

.opname-search{
    width:340px;
    flex:0 0 340px;
}

.opname-search .search-box{
    width:100%;
    height:46px;
    padding:0 15px;
    box-sizing:border-box;
}

.opname-search input{
    width:100%;
    height:46px;
    padding:0 16px;
    border:1px solid #ddd;
    border-radius:10px;
    box-sizing:border-box;
    outline:none;
    font-size:14px;
}

.opname-search input:focus{
    border-color:#1684e0;
}

.opname-date-wrapper,
.opname-status-wrapper{
    position:relative;
    flex:0 0 auto;
}

.opname-date-btn,
.opname-status-btn{
    height:46px;
    min-width:190px;
    padding:0 15px;
    background:#fff;
    border:1px solid #ddd;
    border-radius:10px;
    cursor:pointer;

    display:flex;
    align-items:center;
    justify-content:space-between;

    font-size:14px;
    color:#222;
}

.opname-status-btn{
    min-width:170px;
}

.opname-date-btn:hover,
.opname-status-btn:hover{
    border-color:#1684e0;
}

.opname-dropdown{
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

.opname-dropdown.show{
    display:block;
}

.opname-option{
    width:100%;
    padding:14px 16px;

    background:#fff;
    border:none;

    text-align:left;

    font-size:14px;
    cursor:pointer;
}

.opname-option:hover{
    background:#f3f5fa;
}

.opname-option.active{
    background:#f3f5fa;
    font-weight:600;
}

.opname-custom-date{
    display:none;
    padding:14px;
    border-top:1px solid #eee;
    background:#fff;
}

.opname-custom-date.show{
    display:block;
}

.opname-custom-date label{
    display:block;
    margin-bottom:8px;
    font-size:13px;
    color:#555;
}

.opname-custom-date input{
    width:100%;
    height:40px;
    padding:0 10px;
    border:1px solid #ddd;
    border-radius:8px;
    box-sizing:border-box;
    font-size:13px;
    outline:none;
}

.opname-custom-date input:focus{
    border-color:#1684e0;
}

.opname-custom-date button{
    width:100%;
    margin-top:10px;
    height:40px;
    border:none;
    border-radius:8px;
    background:#1684e0;
    color:#fff;
    cursor:pointer;
    font-size:13px;
}

.opname-custom-date button:hover{
    background:#0f73c5;
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
    gap:10px;
}

.btn{
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    text-decoration:none;
    color:white;
}

.btn-primary{
    background:#1684e0;
}

.filter-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.filter-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.search-box{
    width:260px;
    padding:12px 15px;
    border:1px solid #ddd;
    border-radius:10px;
}

.table-section{
    padding:25px;
}

.table-wrapper{
    overflow-x:auto;
}

.stock-table{
    width:100%;
    border-collapse:collapse;
}

.stock-table th{
    background:#f3f5fa;
    padding:12px;
    text-align:left;
    font-size:14px;
}

.stock-table td{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.no-data{
    text-align:center;
    color:#999;
    padding:40px;
}

.badge-success{
    background:#d4edda;
    color:#155724;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.badge-warning{
    background:#fff3cd;
    color:#856404;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.badge-info{
    background:#d1ecf1;
    color:#0c5460;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.badge-danger{
    background:#f8d7da;
    color:#721c24;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.action-btn{
    color:#1684e0;
    text-decoration:none;
}

.table-footer{
    margin-top:20px;
    display:flex;
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
    color:#a0a0a0;
    font-size:20px;
    padding:0;
}

.delete-btn:hover{
    color:#ff4d4f;
}

</style>

<div class="page-header">

    <div class="top-header">
        Inventory
    </div>

    <div class="filter-section">

        <div class="filter-top">

            <div class="stock-info">

                <h2>Daftar Stok Opname</h2>

                <span>
                    {{ $stockOpnames->count() }} Data Opname
                </span>

            </div>

            <div class="toolbar">

                <a
                    href="{{ route('admin.stok-opname.create') }}"
                    class="btn btn-primary">

                    Tambah Opname

                </a>

            </div>

        </div>

        <div class="opname-filter-row">

            {{-- LIVE SEARCH --}}
            <div class="opname-search">

                <input
                    type="text"
                    id="opnameSearch"
                    class="search-box"
                    placeholder="Cari No. Opname / Keterangan..."
                    autocomplete="off">

            </div>


            {{-- FILTER TANGGAL --}}
            <div class="opname-date-wrapper">

                <button
                    type="button"
                    class="opname-date-btn"
                    id="opnameDateButton">

                    <span>

                        <i class="fa-regular fa-calendar"></i>

                        <span id="opnameDateText">
                            Semua Tanggal
                        </span>

                    </span>

                    <i class="fa-solid fa-chevron-down"></i>

                </button>

                <div
                    class="opname-dropdown"
                    id="opnameDateDropdown">

                    <button
                        type="button"
                        class="opname-option active"
                        data-date-filter="all">

                        Semua Tanggal

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-date-filter="today">

                        Hari Ini

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-date-filter="yesterday">

                        Kemarin

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-date-filter="week">

                        7 Hari Terakhir

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-date-filter="month">

                        Bulan Ini

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        id="customDateOption">

                        Pilih Tanggal...

                    </button>


                    {{-- CALENDAR CUSTOM --}}

                    <div
                        class="opname-custom-date"
                        id="opnameCustomDate">

                        <label for="customOpnameDate">
                            Pilih tanggal
                        </label>

                        <input
                            type="date"
                            id="customOpnameDate">

                        <button
                            type="button"
                            id="applyCustomDate">

                            Terapkan

                        </button>

                    </div>

                </div>

            </div>


            {{-- FILTER STATUS --}}
            <div class="opname-status-wrapper">

                <button
                    type="button"
                    class="opname-status-btn"
                    id="opnameStatusButton">

                    <span id="opnameStatusText">
                        Semua Status
                    </span>

                    <i class="fa-solid fa-chevron-down"></i>

                </button>


                <div
                    class="opname-dropdown"
                    id="opnameStatusDropdown">

                    <button
                        type="button"
                        class="opname-option active"
                        data-status-filter="all">

                        Semua Status

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-status-filter="Draft">

                        Draft

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-status-filter="Disetujui">

                        Disetujui

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-status-filter="Selesai">

                        Selesai

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-status-filter="Dibatalkan">

                        Dibatalkan

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="table-section">

        <div class="table-wrapper">

            <table class="stock-table">

                <thead>

                    <tr>

                        <th width="40">
                            <input type="checkbox" id="checkAll">
                        </th>

                        <th>No Opname</th>

                        <th>Tanggal</th>

                        <th>Catatan</th>

                        <th>Status</th>

                        <th>Diterima Oleh</th>

                        <th>Aksi</th>

                    </tr>

                    </thead>
                
                <tbody>

                @forelse($stockOpnames as $opname)

                <tr
                    class="opname-row"
                    data-date="{{ $opname->tanggal_opname }}"
                    data-status="{{ $opname->status }}">

                    <td>
                        <input
                            type="checkbox"
                            class="row-checkbox"
                            value="{{ $opname->id }}">
                    </td>

                    <td class="opname-number">
                        {{ $opname->nomor_opname }}
                    </td>

                    <td>
                        {{ date('d-m-Y', strtotime($opname->tanggal_opname)) }}
                    </td>

                    <td class="opname-note">
                        {{ $opname->keterangan ?? '-' }}
                    </td>

                    <td>

                        @if($opname->status == 'Draft')

                            <span class="badge-warning">
                                Draft
                            </span>

                        @elseif($opname->status == 'Disetujui')

                            <span class="badge-info">
                                Disetujui
                            </span>

                        @elseif($opname->status == 'Selesai')

                            <span class="badge-success">
                                Selesai
                            </span>

                        @elseif($opname->status == 'Dibatalkan')

                            <span class="badge-danger">
                                Dibatalkan
                            </span>

                        @endif

                    </td>

                    <td>
                        {{ $opname->petugas }}
                    </td>

                    <td>

                        {{-- Detail --}}
                        <a
                            href="{{ route('admin.stok-opname.show',$opname->id) }}"
                            title="Detail"
                            class="action-btn">

                            <i class="fa-solid fa-eye"></i>

                        </a>

                        &nbsp;

                        {{-- Download PDF --}}
                        <a
                            href="{{ route('admin.stok-opname.pdf',$opname->id) }}"
                            title="Download PDF"
                            class="action-btn">

                            <i
                                class="fa-solid fa-file-pdf"
                                style="color:#dc3545">
                            </i>

                        </a>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="10" class="no-data">
                        Belum ada data stok opname
                    </td>
                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="table-footer">

            <div class="footer-left">

                <button
                    id="deleteSelected"
                    class="delete-btn"
                    type="button">

                    <i class="fa-regular fa-trash-can"></i>

                </button>

                <select class="filter-box">

                    <option>10/page</option>
                    <option>25/page</option>
                    <option>50/page</option>

                </select>

                <span>

                    Total {{ $stockOpnames->count() }}

                </span>

            </div>

        </div>

    </div>

</div>

<script>

/* =========================================================
   CHECK ALL
========================================================= */

document
    .getElementById('checkAll')
    .addEventListener('change', function(){

        document
            .querySelectorAll('.row-checkbox')
            .forEach(function(cb){

                cb.checked = this.checked;

            }, this);

    });


/* =========================================================
   BULK DELETE
========================================================= */

document
    .getElementById('deleteSelected')
    .addEventListener('click', function(){

        let ids = [];

        document
            .querySelectorAll('.row-checkbox:checked')
            .forEach(function(cb){

                ids.push(cb.value);

            });


        if(ids.length === 0){

            alert('Pilih data yang akan dihapus');

            return;

        }


        if(!confirm(
            'Yakin ingin menghapus data terpilih?'
        )){

            return;

        }


        fetch(
            "{{ route('admin.stok-opname.bulk-delete') }}",
            {
                method: 'DELETE',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                body: JSON.stringify({
                    ids: ids.join(',')
                })
            }
        )

        .then(response => response.json())

        .then(data => {

            console.log(data);


            if(data.success){

                alert('Berhasil dihapus');

                location.reload();

            }else{

                alert('Gagal hapus');

            }

        })

        .catch(error => {

            console.log(error);

            alert('Terjadi error');

        });

    });


/* =========================================================
   FILTER OPNAME
========================================================= */

let selectedDateFilter = 'all';
let selectedStatusFilter = 'all';
let selectedCustomDate = null;


/* =========================================================
   ELEMENT
========================================================= */

const opnameSearch =
    document.getElementById('opnameSearch');

const opnameRows =
    document.querySelectorAll('.opname-row');

const dateButton =
    document.getElementById('opnameDateButton');

const dateDropdown =
    document.getElementById('opnameDateDropdown');

const dateText =
    document.getElementById('opnameDateText');

const statusButton =
    document.getElementById('opnameStatusButton');

const statusDropdown =
    document.getElementById('opnameStatusDropdown');

const statusText =
    document.getElementById('opnameStatusText');

const customDateOption =
    document.getElementById('customDateOption');

const customDateBox =
    document.getElementById('opnameCustomDate');

const customDateInput =
    document.getElementById('customOpnameDate');

const applyCustomDate =
    document.getElementById('applyCustomDate');


/* =========================================================
   BUKA DROPDOWN TANGGAL
========================================================= */

dateButton.addEventListener('click', function(event){

    event.stopPropagation();

    dateDropdown.classList.toggle('show');

    statusDropdown.classList.remove('show');

});


/* =========================================================
   BUKA DROPDOWN STATUS
========================================================= */

statusButton.addEventListener('click', function(event){

    event.stopPropagation();

    statusDropdown.classList.toggle('show');

    dateDropdown.classList.remove('show');

});


/* =========================================================
   KLIK DI LUAR DROPDOWN
========================================================= */

document.addEventListener('click', function(event){

    if(
        !dateButton.contains(event.target) &&
        !dateDropdown.contains(event.target)
    ){

        dateDropdown.classList.remove('show');

    }


    if(
        !statusButton.contains(event.target) &&
        !statusDropdown.contains(event.target)
    ){

        statusDropdown.classList.remove('show');

    }

});


/* =========================================================
   FORMAT TANGGAL
========================================================= */

function getDateOnly(date){

    return new Date(
        date.getFullYear(),
        date.getMonth(),
        date.getDate()
    );

}


/* =========================================================
   CEK FILTER TANGGAL
========================================================= */

function matchDateFilter(dateValue){

    if(selectedDateFilter === 'all'){

        return true;

    }


    const rowDate =
        new Date(dateValue);


    const today =
        getDateOnly(new Date());


    const targetDate =
        getDateOnly(rowDate);


    /* -------------------------
       HARI INI
    ------------------------- */

    if(selectedDateFilter === 'today'){

        return targetDate.getTime() ===
            today.getTime();

    }


    /* -------------------------
       KEMARIN
    ------------------------- */

    if(selectedDateFilter === 'yesterday'){

        const yesterday =
            new Date(today);


        yesterday.setDate(
            yesterday.getDate() - 1
        );


        return targetDate.getTime() ===
            yesterday.getTime();

    }


    /* -------------------------
       7 HARI TERAKHIR
    ------------------------- */

    if(selectedDateFilter === 'week'){

        const startDate =
            new Date(today);


        startDate.setDate(
            startDate.getDate() - 6
        );


        return targetDate >= startDate &&
            targetDate <= today;

    }


    /* -------------------------
       BULAN INI
    ------------------------- */

    if(selectedDateFilter === 'month'){

        return (
            targetDate.getMonth() ===
            today.getMonth()
        )
        &&
        (
            targetDate.getFullYear() ===
            today.getFullYear()
        );

    }

    if(selectedDateFilter === 'custom'){

        if(!selectedCustomDate){

            return true;

        }


        return dateValue === selectedCustomDate;

    }


    return true;

}


/* =========================================================
   FILTER UTAMA
========================================================= */

function filterOpname(){

    const keyword =
        opnameSearch.value
            .toLowerCase()
            .trim();


    opnameRows.forEach(function(row){

        /* -------------------------
           DATA NOMOR OPNAME
        ------------------------- */

        const nomor =
            row
                .querySelector('.opname-number')
                ?.textContent
                .toLowerCase()
                .trim() || '';


        /* -------------------------
           DATA KETERANGAN
        ------------------------- */

        const keterangan =
            row
                .querySelector('.opname-note')
                ?.textContent
                .toLowerCase()
                .trim() || '';


        /* -------------------------
           DATA STATUS
        ------------------------- */

        const status =
            row.dataset.status || '';


        /* -------------------------
           DATA TANGGAL
        ------------------------- */

        const tanggal =
            row.dataset.date || '';


        /* -------------------------
           FILTER SEARCH
        ------------------------- */

        const cocokSearch =
            nomor.includes(keyword) ||
            keterangan.includes(keyword);


        /* -------------------------
           FILTER STATUS
        ------------------------- */

        const cocokStatus =
            selectedStatusFilter === 'all' ||
            status === selectedStatusFilter;


        /* -------------------------
           FILTER TANGGAL
        ------------------------- */

        const cocokTanggal =
            matchDateFilter(tanggal);


        /* -------------------------
           HASIL AKHIR
        ------------------------- */

        if(
            cocokSearch &&
            cocokStatus &&
            cocokTanggal
        ){

            row.style.display = '';

        }else{

            row.style.display = 'none';

        }

    });

}


/* =========================================================
   LIVE SEARCH
========================================================= */

opnameSearch.addEventListener(
    'input',
    function(){

        filterOpname();

    }
);


/* =========================================================
   PILIH FILTER TANGGAL
========================================================= */

document
    .querySelectorAll('[data-date-filter]')
    .forEach(function(option){

        option.addEventListener(
            'click',
            function(){

                selectedDateFilter =
                    this.dataset.dateFilter;


                dateText.textContent =
                    this.textContent.trim();


                document
                    .querySelectorAll(
                        '[data-date-filter]'
                    )
                    .forEach(function(item){

                        item.classList.remove(
                            'active'
                        );

                    });


                this.classList.add('active');


                dateDropdown.classList.remove(
                    'show'
                );


                filterOpname();

            }
        );

    });

/* =========================================================
   PILIH TANGGAL CUSTOM
========================================================= */

customDateOption.addEventListener(
    'click',
    function(event){

        event.stopPropagation();

        customDateBox.classList.toggle('show');

    }
);

/* =========================================================
   TERAPKAN TANGGAL CUSTOM
========================================================= */

applyCustomDate.addEventListener(
    'click',
    function(){

        const selected =
            customDateInput.value;


        if(!selected){

            alert('Silakan pilih tanggal terlebih dahulu.');

            return;

        }


        selectedCustomDate = selected;

        selectedDateFilter = 'custom';


        dateText.textContent =
            formatCustomDate(selected);


        document
            .querySelectorAll(
                '[data-date-filter]'
            )
            .forEach(function(item){

                item.classList.remove(
                    'active'
                );

            });


        customDateOption.classList.add(
            'active'
        );


        customDateBox.classList.remove(
            'show'
        );


        dateDropdown.classList.remove(
            'show'
        );


        filterOpname();

    }
);

/* =========================================================
   FORMAT TANGGAL CUSTOM
========================================================= */

function formatCustomDate(dateValue){

    const parts =
        dateValue.split('-');


    if(parts.length !== 3){

        return dateValue;

    }


    return (
        parts[2] +
        '-' +
        parts[1] +
        '-' +
        parts[0]
    );

}

/* =========================================================
   PILIH FILTER STATUS
========================================================= */

document
    .querySelectorAll('[data-status-filter]')
    .forEach(function(option){

        option.addEventListener(
            'click',
            function(){

                selectedStatusFilter =
                    this.dataset.statusFilter;


                statusText.textContent =
                    this.textContent.trim();


                document
                    .querySelectorAll(
                        '[data-status-filter]'
                    )
                    .forEach(function(item){

                        item.classList.remove(
                            'active'
                        );

                    });


                this.classList.add('active');


                statusDropdown.classList.remove(
                    'show'
                );


                filterOpname();

            }
        );

    });

</script>

@endsection