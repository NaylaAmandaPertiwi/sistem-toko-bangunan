@extends('layouts.admin')

@section('title', 'Manajemen Kasir')

@section('content')

<style>

.staff-page{
    width:100%;
}


/* =========================
   CARD UTAMA
========================= */

.staff-card{

    background:#ffffff;

    border-radius:16px;

    overflow:hidden;

    box-shadow:
        0 2px 10px
        rgba(0,0,0,.05);
}


/* =========================
   HEADER BIRU
========================= */

.staff-header{

    background:#1684e0;

    color:white;

    padding:18px 25px;

    font-size:28px;

    font-weight:600;
}


/* =========================
   BAGIAN ATAS
========================= */

.staff-top-section{

    padding:25px;

    display:flex;

    justify-content:space-between;

    align-items:center;
}


/* =========================
   JUDUL DAFTAR
========================= */

.staff-section-title{

    font-size:20px;

    font-weight:700;

    color:#24324a;
}


/* =========================
   SEARCH
========================= */

.staff-search{

    width:280px;

    padding:12px;

    border:1px solid #ddd;

    border-radius:10px;

    font-size:14px;

    outline:none;

    transition:.2s;
}

.staff-search:focus{

    border-color:#4e73df;

    box-shadow:
        0 0 0 3px
        rgba(78,115,223,.12);
}


/* =========================
   BUTTON TAMBAH
========================= */

.btn-add-staff{

    background:#4CAF50;

    color:white;

    text-decoration:none;

    padding:12px 18px;

    border-radius:10px;

    display:inline-flex;

    align-items:center;

    gap:8px;

    font-size:14px;

    font-weight:600;

    transition:.2s;
}

.btn-add-staff:hover{

    background:#43a047;
}


/* =========================
   FILTER
========================= */

.staff-filter{

    padding:0 25px 25px;

    display:flex;

    justify-content:space-between;

    align-items:center;
}


/* =========================
   TABLE
========================= */

.staff-table-section{

    padding:0 25px 25px;
}

.staff-table-wrapper{

    width:100%;

    overflow-x:auto;
}

.staff-table{

    width:100%;

    border-collapse:collapse;
}


/* HEADER TABLE */

.staff-table th{

    background:#f3f5fa;

    padding:14px;

    text-align:left;

    color:#344054;

    font-size:14px;

    font-weight:700;
}


/* ISI TABLE */

.staff-table td{

    padding:14px;

    border-bottom:1px solid #eee;

    color:#344054;

    font-size:14px;
}


/* HOVER */

.staff-table tbody tr:hover{

    background:#fafbfc;
}


/* =========================
   NOMOR
========================= */

.staff-number{

    width:60px;

    text-align:center;
}


/* =========================
   NAMA
========================= */

.staff-name{

    font-weight:600;

    color:#24324a;
}


/* =========================
   ROLE
========================= */

.staff-role{

    display:inline-flex;

    align-items:center;

    padding:6px 12px;

    border-radius:20px;

    background:#eef4ff;

    color:#355cc9;

    font-size:12px;

    font-weight:600;
}

/* =========================
   STATUS
========================= */

.staff-status{

    display:inline-flex;

    align-items:center;

    gap:7px;

    padding:6px 12px;

    border-radius:20px;

    font-size:12px;

    font-weight:600;
}


.staff-status-active{

    background:#dcfce7;

    color:#15803d;
}


.staff-status-inactive{

    background:#fee2e2;

    color:#b91c1c;
}


.status-dot{

    width:7px;

    height:7px;

    border-radius:50%;

    background:currentColor;
}

/* =========================
   EMPTY
========================= */

.empty-state{

    text-align:center;

    padding:40px 20px;

    color:#667085;
}

.empty-state i{

    display:block;

    font-size:35px;

    margin-bottom:12px;

    color:#98a2b3;
}

.empty-state p{

    margin:0;

    font-size:14px;
}

/* =========================
   AKSI
========================= */

.staff-action-header{
    text-align:center;
    white-space:nowrap;
}

.staff-action-cell{
    text-align:center;
    white-space:nowrap;
}

.staff-action-disable{

    background:#fee2e2;

    color:#dc2626;
}


.staff-action-disable:hover{

    background:#fecaca;

    color:#b91c1c;
}


.staff-action-enable{

    background:#dcfce7;

    color:#16a34a;
}


.staff-action-enable:hover{

    background:#bbf7d0;

    color:#15803d;
}


/* =========================
   RESET PASSWORD
========================= */

.btn-reset-password{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    width:36px;

    height:36px;

    margin-right:6px;

    border-radius:8px;

    background:#fff3cd;

    color:#b7791f;

    text-decoration:none;

    transition:.2s;
}


.btn-reset-password:hover{

    background:#ffe69c;

    color:#8a5a00;

}


/* =========================
   NONAKTIFKAN
========================= */

.btn-deactivate{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    width:36px;

    height:36px;

    border:none;

    border-radius:8px;

    background:#ffe0e0;

    color:#dc2626;

    cursor:pointer;

    transition:.2s;
}


.btn-deactivate:hover{

    background:#ffc7c7;

}


/* =========================
   AKTIFKAN
========================= */

.btn-activate{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    width:36px;

    height:36px;

    border:none;

    border-radius:8px;

    background:#dcfce7;

    color:#16a34a;

    cursor:pointer;

    transition:.2s;
}


.btn-activate:hover{

    background:#bbf7d0;

}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){

    .staff-top-section{

        flex-direction:column;

        align-items:flex-start;

        gap:15px;
    }

    .staff-filter{

        flex-direction:column;

        align-items:stretch;

        gap:15px;
    }

    .staff-search{

        width:100%;
    }

    .btn-add-staff{

        justify-content:center;
    }

}

</style>


<div class="staff-page">


    {{-- =========================
         CARD UTAMA
    ========================== --}}

    <div class="staff-card">


        {{-- =========================
             HEADER BIRU
        ========================== --}}

        <div class="staff-header">

            Manajemen Kasir

        </div>


        {{-- =========================
             JUDUL + TOMBOL
        ========================== --}}

        <div class="staff-top-section">

            <div class="staff-section-title">

                Daftar Kasir

            </div>


            <a
                href="{{ route('admin.staff.create') }}"
                class="btn-add-staff"
            >

                <i class="fa-solid fa-plus"></i>

                Tambah Kasir

            </a>

        </div>


        {{-- =========================
             SEARCH
        ========================== --}}

        <div class="staff-filter">

            <input
                type="text"
                id="staffSearch"
                class="staff-search"
                placeholder="Cari Kasir..."
                autocomplete="off"
            >

        </div>


        {{-- =========================
             TABLE
        ========================== --}}

        <div class="staff-table-section">

            <div class="staff-table-wrapper">

                <table class="staff-table">

                    <thead>

                        <tr>

                            <th class="staff-number">
                                No
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Username
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Terdaftar Sejak
                            </th>

                            <th class="staff-action-header">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody id="staffTableBody">


                        @forelse($kasirs as $index => $kasir)

                            <tr>


                                {{-- NO --}}

                                <td class="staff-number">

                                    {{ $index + 1 }}

                                </td>


                                {{-- NAMA --}}

                                <td>

                                    <span class="staff-name">

                                        {{ $kasir->name }}

                                    </span>

                                </td>


                                {{-- USERNAME --}}

                                <td>

                                    {{ $kasir->username }}

                                </td>


                                {{-- ROLE --}}

                                <td>

                                    <span class="staff-role">

                                        {{ $kasir->role }}

                                    </span>

                                </td>

                                {{-- STATUS --}}

                                <td>

                                    @if($kasir->status === 'Aktif')

                                        <span class="staff-status staff-status-active">

                                            <span class="status-dot"></span>

                                            Aktif

                                        </span>

                                    @else

                                        <span class="staff-status staff-status-inactive">

                                            <span class="status-dot"></span>

                                            Nonaktif

                                        </span>

                                    @endif

                                </td>


                                {{-- TANGGAL --}}

                                <td>

                                    {{ $kasir->created_at->translatedFormat('d M Y') }}

                                </td>


                                {{-- AKSI --}}

                                <td class="staff-action-cell">

                                    {{-- RESET PASSWORD --}}

                                    <a
                                        href="{{ route(
                                            'admin.staff.reset-password',
                                            $kasir->id
                                        ) }}"
                                        class="btn-reset-password"
                                        title="Reset Password"
                                    >

                                        <i class="fa-solid fa-key"></i>

                                    </a>


                                    {{-- STATUS AKUN --}}

                                    @if($kasir->status === 'Aktif')

                                        <form
                                            action="{{ route(
                                                'admin.staff.deactivate',
                                                $kasir->id
                                            ) }}"
                                            method="POST"
                                            style="display:inline;"
                                        >

                                            @csrf

                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn-deactivate"
                                                title="Nonaktifkan"
                                                onclick="return confirm(
                                                    'Apakah Anda yakin ingin menonaktifkan Kasir ini?'
                                                )"
                                            >

                                                <i class="fa-solid fa-pause"></i>

                                            </button>

                                        </form>

                                    @else

                                        <form
                                            action="{{ route(
                                                'admin.staff.activate',
                                                $kasir->id
                                            ) }}"
                                            method="POST"
                                            style="display:inline;"
                                        >

                                            @csrf

                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn-activate"
                                                title="Aktifkan"
                                            >

                                                <i class="fa-solid fa-play"></i>

                                            </button>

                                        </form>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="7">

                                    <div class="empty-state">

                                        <i class="fa-solid fa-users"></i>

                                        <p>
                                            Belum ada akun Kasir.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse


                    </tbody>

                </table>

            </div>

        </div>


    </div>

</div>


@endsection


@section('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const searchInput =
            document.getElementById(
                'staffSearch'
            );

        const tableBody =
            document.getElementById(
                'staffTableBody'
            );


        searchInput.addEventListener(
            'input',
            function () {

                const keyword =
                    this.value
                        .toLowerCase()
                        .trim();


                const rows =
                    tableBody.querySelectorAll(
                        'tr'
                    );


                rows.forEach(
                    function (row) {

                        const text =
                            row.textContent
                                .toLowerCase();


                        if (
                            text.includes(keyword)
                        ) {

                            row.style.display =
                                '';

                        } else {

                            row.style.display =
                                'none';

                        }

                    }
                );

            }
        );

    }
);

</script>

@endsection