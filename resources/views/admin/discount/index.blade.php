@extends('layouts.admin')

@section('title','Diskon')

@section('content')

<style>

.page-card{
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
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.search-box{
    width:280px;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.add-btn{
    background:#4CAF50;
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:10px;
}

.table-section{
    padding:25px;
}

.discount-table{
    width:100%;
    border-collapse:collapse;
}

.discount-table th{
    background:#f3f5fa;
    padding:14px;
    text-align:left;
}

.discount-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.status-active{
    background:#d4edda;
    color:#155724;
    padding:6px 12px;
    border-radius:20px;
}

.status-inactive{
    background:#f8d7da;
    color:#721c24;
    padding:6px 12px;
    border-radius:20px;
}

.edit-btn{
    color:#6a1b9a;
    text-decoration:none;
    margin-right:12px;
}

.delete-btn{
    color:#dc3545;
    border:none;
    background:none;
    cursor:pointer;
    font-size:16px;
    padding:0;
}

</style>


<div class="page-card">


    {{-- HEADER --}}

    <div class="top-header">

        Diskon

    </div>


    {{-- FILTER --}}

    <div class="filter-section">

        <form
            method="GET"
            action="{{ route('admin.discount.index') }}">

            <input
                type="text"
                id="discountSearch"
                class="search-box"
                placeholder="Cari Diskon..."
                autocomplete="off">

        </form>


        <a
            href="{{ route('admin.discount.create') }}"
            class="add-btn">

            Tambah Diskon

        </a>

    </div>


    {{-- TABLE --}}

    <div class="table-section">

        <table class="discount-table">

            <thead>

                <tr>

                    <th>
                        Nama Diskon
                    </th>

                    <th>
                        Minimal Belanja
                    </th>

                    <th>
                        Diskon (%)
                    </th>

                    <th>
                        Periode Diskon
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody id="discountTableBody">


            @forelse($discounts as $discount)


                @php

                    $today =
                        \Carbon\Carbon::today();


                    $tanggalMulai =
                        \Carbon\Carbon::parse(
                            $discount->tanggal_mulai
                        );


                    $tanggalBerakhir =
                        \Carbon\Carbon::parse(
                            $discount->tanggal_berakhir
                        );


                    $periodeAktif =
                        $today->greaterThanOrEqualTo(
                            $tanggalMulai
                        )
                        &&
                        $today->lessThanOrEqualTo(
                            $tanggalBerakhir
                        );


                    $statusAktif =
                        $discount->status === 'Aktif'
                        &&
                        $periodeAktif;

                @endphp


                <tr>


                    {{-- NAMA --}}

                    <td>

                        {{ $discount->nama_diskon }}

                    </td>


                    {{-- MINIMAL BELANJA --}}

                    <td>

                        Rp
                        {{ number_format(
                            $discount->minimal_belanja,
                            0,
                            ',',
                            '.'
                        ) }}

                    </td>


                    {{-- PERSENTASE --}}

                    <td>

                        {{ $discount->persentase_diskon }}%

                    </td>


                    {{-- PERIODE --}}

                    <td>

                        {{ $tanggalMulai->translatedFormat('d M Y') }}

                        <span
                            style="
                                color:#777;
                                margin:0 5px;
                            ">

                            -

                        </span>

                        {{ $tanggalBerakhir->translatedFormat('d M Y') }}

                    </td>


                    {{-- STATUS --}}

                    <td>

                        @if($statusAktif)

                            <span class="status-active">

                                Aktif

                            </span>

                        @else

                            <span class="status-inactive">

                                Nonaktif

                            </span>

                        @endif

                    </td>


                    {{-- AKSI --}}

                    <td>


                        {{-- EDIT --}}

                        <a
                            href="{{ route(
                                'admin.discount.edit',
                                $discount->id
                            ) }}"
                            class="edit-btn">

                            <i
                                class="fa-solid fa-pen">
                            </i>

                        </a>


                        {{-- DELETE --}}

                        <form
                            action="{{ route(
                                'admin.discount.destroy',
                                $discount->id
                            ) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="delete-btn"
                                onclick="return confirm(
                                    'Apakah Anda yakin ingin menghapus diskon ini?'
                                )">

                                <i
                                    class="fa-solid fa-trash">
                                </i>

                            </button>

                        </form>


                    </td>


                </tr>


            @empty


                <tr>

                    <td
                        colspan="6"
                        style="text-align:center;">

                        Belum ada data diskon

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

    const searchInput = document.getElementById('discountSearch');
    const tableBody = document.getElementById('discountTableBody');

    searchInput.addEventListener('input', function () {

        const keyword = this.value
            .toLowerCase()
            .trim();

        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(function (row) {

            const text = row.textContent.toLowerCase();

            if (text.includes(keyword)) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    });

});

</script>

@endsection