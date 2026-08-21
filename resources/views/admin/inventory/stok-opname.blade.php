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

/* ==========================================================
   TOOLBAR FILTER OPNAME
========================================================== */

.opname-filter-row{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:15px;
    margin-top:30px;
    margin-bottom:30px;
}


/* ==========================================================
   SEARCH
========================================================== */

.opname-search{
    width:285px;
    flex:0 0 285px;
}

.opname-search input{
    width:100%;
    height:46px;

    padding:0 15px;

    border:1px solid #ddd;
    border-radius:10px;

    outline:none;

    font-size:14px;

    box-sizing:border-box;
}

.opname-search input:focus{
    border-color:#1684e0;
}


/* ==========================================================
   FILTER STATUS
========================================================== */

.opname-status-wrapper{
    position:relative;
}

.opname-status-btn{

    width:180px;
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

.opname-status-btn:hover{
    border-color:#1684e0;
}

.opname-status-btn i{
    font-size:11px;
    color:#666;

    transition:transform .2s ease;
}

.opname-status-wrapper.active
.opname-status-btn i{
    transform:rotate(180deg);
}


/* ==========================================================
   FILTER TANGGAL
========================================================== */

.opname-date-wrapper{
    position:relative;
}

.opname-date-btn{

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

    box-sizing:border-box;
}

.opname-date-btn:hover{
    border-color:#1684e0;
}

.opname-date-btn i{
    color:#222;
}


/* ==========================================================
   DROPDOWN
========================================================== */

.opname-dropdown{

    position:absolute;

    top:54px;

    width:230px;

    background:#fff;

    border:1px solid #ddd;
    border-radius:10px;

    box-shadow:0 8px 25px rgba(0,0,0,.08);

    display:none;

    overflow:hidden;

    z-index:4000;
}

.opname-dropdown.show{
    display:block;
}


/* STATUS DROPDOWN */

.opname-status-wrapper .opname-dropdown{

    left:0;

    width:180px;

}


/* TANGGAL DROPDOWN */

.opname-date-wrapper .opname-dropdown{

    right:0;

    width:230px;

}


/* ==========================================================
   OPTION
========================================================== */

.opname-option{

    width:100%;

    padding:12px 16px;

    border:none;

    background:#fff;

    text-align:left;

    font-size:14px;

    color:#222;

    cursor:pointer;
}

.opname-option:hover{
    background:#f4f6fb;
}

.opname-option.active{
    background:#f4f6fb;
    font-weight:600;
}


/* ==========================================================
   CUSTOM DATE
========================================================== */

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

/* =========================================================
   MODAL PILIH TANGGAL
========================================================= */

.opname-date-modal{

    position:fixed;

    inset:0;

    background:rgba(0,0,0,.35);

    display:none;

    align-items:center;

    justify-content:center;

    z-index:9999;

}


.opname-date-modal.show{

    display:flex;

}


.opname-date-modal-box{

    width:440px;

    background:#fff;

    border-radius:16px;

    box-shadow:0 10px 35px rgba(0,0,0,.20);

    overflow:hidden;

}


.opname-date-modal-header{

    padding:20px;

    border-bottom:1px solid #eee;

}


.opname-date-modal-header h3{

    margin:0;

    font-size:20px;

    color:#222;

}


.opname-date-modal-header i{

    margin-right:8px;

}


.opname-date-modal-body{

    padding:22px;

}


.opname-date-modal-body input{

    width:100%;

    height:48px;

    padding:0 14px;

    border:1px solid #ddd;

    border-radius:10px;

    font-size:14px;

    box-sizing:border-box;

    outline:none;

}


.opname-date-modal-body input:focus{

    border-color:#1684e0;

}


.opname-date-modal-footer{

    display:flex;

    justify-content:flex-end;

    gap:10px;

    padding:16px 20px;

    border-top:1px solid #eee;

}


.opname-date-cancel,
.opname-date-save{

    height:40px;

    padding:0 20px;

    border:none;

    border-radius:8px;

    cursor:pointer;

    font-size:14px;

}


.opname-date-cancel{

    background:#eee;

    color:#333;

}


.opname-date-save{

    background:#1684e0;

    color:#fff;

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

            {{-- ==================================================
                SEARCH
            ================================================== --}}

            <div class="opname-search">

                <input
                    type="text"
                    id="opnameSearch"
                    placeholder="Cari No. Opname / Keterangan..."
                    autocomplete="off"
                    value=""
                >

            </div>


            {{-- ==================================================
                FILTER STATUS
            ================================================== --}}

            <div class="opname-status-wrapper">

                <button
                    type="button"
                    class="opname-status-btn"
                    id="opnameStatusButton">

                    <span id="opnameStatusText">

                        @switch(request('status'))

                            @case('Draft')
                                Draft
                                @break

                            @case('Disetujui')
                                Disetujui
                                @break

                            @case('Selesai')
                                Selesai
                                @break

                            @case('Dibatalkan')
                                Dibatalkan
                                @break

                            @default
                                Semua Status

                        @endswitch

                    </span>

                    <i class="fa-solid fa-chevron-down"></i>

                </button>


                <div
                    class="opname-dropdown"
                    id="opnameStatusDropdown">

                    <button
                        type="button"
                        class="opname-option"
                        data-status="">

                        Semua Status

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-status="Draft">

                        Draft

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-status="Disetujui">

                        Disetujui

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-status="Selesai">

                        Selesai

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-status="Dibatalkan">

                        Dibatalkan

                    </button>

                </div>

            </div>


            {{-- ==================================================
                FILTER TANGGAL
            ================================================== --}}

            <div class="opname-date-wrapper">

                <button
                    type="button"
                    class="opname-date-btn"
                    id="opnameDateButton">

                    <span>

                        <i class="fa-regular fa-calendar"></i>

                        <span id="opnameDateText">

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

                    </span>

                    <i class="fa-solid fa-chevron-down"></i>

                </button>


                <div
                    class="opname-dropdown"
                    id="opnameDateDropdown">

                    <button
                        type="button"
                        class="opname-option"
                        data-filter="all">

                        Semua Tanggal

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-filter="today">

                        Hari Ini

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-filter="yesterday">

                        Kemarin

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-filter="week">

                        7 Hari Terakhir

                    </button>

                    <button
                        type="button"
                        class="opname-option"
                        data-filter="month">

                        Bulan Ini

                    </button>

                    <hr style="margin:0;border:0;border-top:1px solid #eee;">

                    <button
                        type="button"
                        class="opname-option"
                        id="customDateOption">

                        Pilih Tanggal...

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

<!-- =========================================================
     MODAL PILIH TANGGAL
========================================================= -->

<div
    class="opname-date-modal"
    id="opnameDateModal">

    <div class="opname-date-modal-box">

        <div class="opname-date-modal-header">

            <h3>
                <i class="fa-regular fa-calendar"></i>
                Pilih Tanggal
            </h3>

        </div>


        <div class="opname-date-modal-body">

            <input
                type="date"
                id="opnameCustomDate"
            >

        </div>


        <div class="opname-date-modal-footer">

            <button
                type="button"
                id="cancelOpnameDate"
                class="opname-date-cancel">

                Batal

            </button>


            <button
                type="button"
                id="saveOpnameDate"
                class="opname-date-save">

                Simpan

            </button>

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
   MENYAMAKAN PERILAKU DENGAN PERGERAKAN STOK
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function(){

        const searchInput =
            document.getElementById('opnameSearch');


        /* ==================================================
           FILTER STATUS
        ================================================== */

        const statusWrapper =
            document.querySelector(
                '.opname-status-wrapper'
            );

        const statusButton =
            document.getElementById(
                'opnameStatusButton'
            );

        const statusDropdown =
            document.getElementById(
                'opnameStatusDropdown'
            );


        statusButton.addEventListener(
            'click',
            function(event){

                event.stopPropagation();

                statusDropdown.classList.toggle(
                    'show'
                );

                statusWrapper.classList.toggle(
                    'active'
                );

                document
                    .getElementById('opnameDateDropdown')
                    .classList.remove('show');

                document
                    .querySelector('.opname-date-wrapper')
                    .classList.remove('active');

            }
        );


        /* ==================================================
           PILIH STATUS
        ================================================== */

        document
            .querySelectorAll(
                '[data-status]'
            )
            .forEach(
                function(option){

                    option.addEventListener(
                        'click',
                        function(){

                            const status =
                                this.dataset.status;


                            const url =
                                new URL(
                                    window.location.href
                                );


                            if(status){

                                url.searchParams.set(
                                    'status',
                                    status
                                );

                            }else{

                                url.searchParams.delete(
                                    'status'
                                );

                            }


                            url.searchParams.delete(
                                'page'
                            );


                            /*
                             * Pertahankan search
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


                            window.location.href =
                                url.toString();

                        }
                    );

                }
            );


        /* ==================================================
           FILTER TANGGAL
        ================================================== */

        const dateWrapper =
            document.querySelector(
                '.opname-date-wrapper'
            );

        const dateButton =
            document.getElementById(
                'opnameDateButton'
            );

        const dateDropdown =
            document.getElementById(
                'opnameDateDropdown'
            );


        dateButton.addEventListener(
            'click',
            function(event){

                event.stopPropagation();

                dateDropdown.classList.toggle(
                    'show'
                );

                dateWrapper.classList.toggle(
                    'active'
                );

                statusDropdown.classList.remove(
                    'show'
                );

                statusWrapper.classList.remove(
                    'active'
                );

            }
        );


        /* ==================================================
           PILIH FILTER TANGGAL
        ================================================== */

        document
            .querySelectorAll(
                '[data-filter]'
            )
            .forEach(
                function(option){

                    option.addEventListener(
                        'click',
                        function(){

                            const filter =
                                this.dataset.filter;


                            const url =
                                new URL(
                                    window.location.href
                                );


                            if(filter === 'all'){

                                url.searchParams.delete(
                                    'filter'
                                );

                                url.searchParams.delete(
                                    'tanggal'
                                );

                            }else{

                                url.searchParams.set(
                                    'filter',
                                    filter
                                );

                                url.searchParams.delete(
                                    'tanggal'
                                );

                            }


                            url.searchParams.delete(
                                'page'
                            );


                            /*
                             * Pertahankan search
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
                             * Pertahankan status
                             */

                            const status =
                                new URL(
                                    window.location.href
                                ).searchParams.get(
                                    'status'
                                );


                            if(status){

                                url.searchParams.set(
                                    'status',
                                    status
                                );

                            }


                            window.location.href =
                                url.toString();

                        }
                    );

                }
            );


        /* =========================================================
        LIVE SEARCH
        ========================================================= */

        searchInput.addEventListener(
            'input',
            function(){

                const keyword =
                    this.value
                        .toLowerCase()
                        .trim();


                document
                    .querySelectorAll('.opname-row')
                    .forEach(function(row){

                        const nomor =
                            row
                                .querySelector('.opname-number')
                                .textContent
                                .toLowerCase();


                        const keterangan =
                            row
                                .querySelector('.opname-note')
                                .textContent
                                .toLowerCase();


                        if(
                            nomor.includes(keyword) ||
                            keterangan.includes(keyword)
                        ){

                            row.style.display = '';

                        }else{

                            row.style.display = 'none';

                        }

                    });

            }
        );


        /* ==================================================
           TUTUP DROPDOWN KETIKA KLIK DI LUAR
        ================================================== */

        document.addEventListener(
            'click',
            function(event){

                if(
                    !statusWrapper.contains(
                        event.target
                    )
                ){

                    statusDropdown.classList.remove(
                        'show'
                    );

                    statusWrapper.classList.remove(
                        'active'
                    );

                }


                if(
                    !dateWrapper.contains(
                        event.target
                    )
                ){

                    dateDropdown.classList.remove(
                        'show'
                    );

                    dateWrapper.classList.remove(
                        'active'
                    );

                }

            }
        );

    }
);

/* ==================================================
   CUSTOM DATE - PILIH TANGGAL
================================================== */

document.addEventListener('DOMContentLoaded', function () {

    const customDateOption =
        document.getElementById('customDateOption');

    const dateDropdown =
        document.getElementById('opnameDateDropdown');

    const dateWrapper =
        document.querySelector('.opname-date-wrapper');

    const dateModal =
        document.getElementById('opnameDateModal');

    const customDateInput =
        document.getElementById('opnameCustomDate');

    const cancelDateButton =
        document.getElementById('cancelOpnameDate');

    const saveDateButton =
        document.getElementById('saveOpnameDate');


    /* ================================================
       KLIK "PILIH TANGGAL..."
    ================================================ */

    if (customDateOption) {

        customDateOption.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            // Tutup dropdown
            if (dateDropdown) {
                dateDropdown.classList.remove('show');
            }

            if (dateWrapper) {
                dateWrapper.classList.remove('active');
            }

            // Buka modal
            if (dateModal) {
                dateModal.classList.add('show');
            }

        });

    }


    /* ================================================
       TOMBOL BATAL
    ================================================ */

    if (cancelDateButton) {

        cancelDateButton.addEventListener('click', function (event) {

            event.preventDefault();

            if (dateModal) {
                dateModal.classList.remove('show');
            }

        });

    }


    /* ================================================
       TOMBOL SIMPAN
    ================================================ */

    if (saveDateButton) {

        saveDateButton.addEventListener('click', function (event) {

            event.preventDefault();

            const tanggal =
                customDateInput
                    ? customDateInput.value
                    : '';


            if (!tanggal) {

                alert(
                    'Silakan pilih tanggal terlebih dahulu.'
                );

                return;

            }


            const url =
                new URL(window.location.href);


            /* Filter tanggal */
            url.searchParams.set(
                'filter',
                'custom'
            );


            /* Tanggal yang dipilih */
            url.searchParams.set(
                'tanggal',
                tanggal
            );


            /* Reset pagination */
            url.searchParams.delete(
                'page'
            );


            /*
             * Pertahankan status
             */

            const status =
                url.searchParams.get('status');

            if (status) {

                url.searchParams.set(
                    'status',
                    status
                );

            }


            /*
             * Search tidak dimasukkan
             * karena live search berjalan
             * di frontend.
             */

            url.searchParams.delete(
                'search'
            );


            /* Tutup modal */
            if (dateModal) {

                dateModal.classList.remove(
                    'show'
                );

            }


            /* Jalankan filter */
            window.location.href =
                url.toString();

        });

    }


    /* ================================================
       KLIK DI LUAR MODAL
    ================================================ */

    if (dateModal) {

        dateModal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === dateModal
                ) {

                    dateModal.classList.remove(
                        'show'
                    );

                }

            }
        );

    }

});
</script>

@endsection