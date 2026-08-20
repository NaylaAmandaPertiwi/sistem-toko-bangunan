@extends('layouts.admin')

@section('title', 'Barcode')

@section('content')

@php
    $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
@endphp

<style>

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

/* =========================================================
   BARCODE TOOLBAR
   ========================================================= */

.barcode-toolbar{
    padding:25px;

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    gap:20px;
}


/* =========================================================
   JUDUL KECIL
   ========================================================= */

.barcode-info h2{
    margin:0 0 4px 0;

    font-size:20px;

    font-weight:700;

    color:#111;
}

.barcode-info span{
    color:#999;

    font-size:16px;
}


/* =========================================================
   SEARCH + KATEGORI + CETAK
   ========================================================= */

.barcode-actions{
    display:flex;

    align-items:center;

    gap:12px;
}


/* =========================================================
   SEARCH
   ========================================================= */

.search-box{
    width:280px;
}

.search-box input{
    width:100%;

    box-sizing:border-box;

    padding:12px 15px;

    border:1px solid #ddd;

    border-radius:10px;

    font-size:14px;

    outline:none;
}

.search-box input:focus{
    border-color:#1684e0;
}

/* CATEGORY DROPDOWN */

.category-filter{
    position:relative;
    width:220px;
}

.category-dropdown-btn{
    width:100%;
    padding:12px 15px;

    background:white;

    border:1px solid #ddd;
    border-radius:10px;

    font-size:14px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    cursor:pointer;

    color:#222;
}

.category-dropdown-btn:hover{
    border-color:#1684e0;
}

.category-dropdown-btn i{
    font-size:12px;
    color:#777;
}

.category-dropdown{
    position:absolute;

    top:calc(100% + 6px);
    left:0;

    width:100%;

    background:white;

    border:1px solid #ddd;
    border-radius:10px;

    box-shadow:0 5px 15px rgba(0,0,0,.12);

    padding:8px;

    z-index:1000;

    display:none;
}

.category-dropdown.show{
    display:block;
}

.category-dropdown input{
    width:100%;

    box-sizing:border-box;

    padding:10px 12px;

    border:1px solid #ddd;

    border-radius:8px;

    outline:none;

    font-size:13px;

    margin-bottom:6px;
}

.category-dropdown input:focus{
    border-color:#1684e0;
}

.category-list{
    max-height:220px;

    overflow-y:auto;
}

.category-option{
    padding:10px 12px;

    border-radius:7px;

    cursor:pointer;

    font-size:14px;
}

.category-option:hover{
    background:#f1f5fb;
}

.category-option.active{
    background:#e8f2fc;

    color:#1684e0;

    font-weight:600;
}

.print-all-btn{

    background:#28a745;

    color:white;

    border:none;

    padding:12px 18px;

    border-radius:10px;

    cursor:pointer;
}

.table-section{
    padding:25px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f3f5fa;

    padding:15px;
}

table td{
    padding:15px;

    border-bottom:1px solid #eee;
}

.no-data{
    text-align:center;

    padding:40px;

    color:#999;
}

.barcode-preview{
    min-width:180px;
    vertical-align:middle;
}

.barcode-preview svg{
    width:160px;
    height:55px;
    display:block;
}

.barcode-number{
    margin-top:4px;
    font-size:13px;
    color:#333;
}

.no-barcode{
    color:#999;
    font-size:13px;
}

.print-btn{
    display:inline-flex;

    align-items:center;
    justify-content:center;

    background:#1684e0;

    color:white;

    border:none;

    padding:8px 14px;

    border-radius:8px;

    cursor:pointer;

    text-decoration:none;
}

</style>

<div class="page-header">

    <div class="top-header">

        Barcode Produk

    </div>

    <!-- BARCODE TOOLBAR -->

    <div class="barcode-toolbar">

        <!-- JUDUL DAN JUMLAH BARCODE -->

        <div class="barcode-info">

            <h2>
                Daftar Barcode
            </h2>

            <span>
                {{ $products->count() }} Barcode
            </span>

        </div>


        <!-- SEARCH + KATEGORI + CETAK -->

        <div class="barcode-actions">


            <!-- SEARCH PRODUK -->

            <div class="search-box">

                <input
                    type="text"
                    id="barcodeSearch"
                    placeholder="Cari Produk atau Barcode"
                    autocomplete="off"
                >

            </div>


            <!-- DROPDOWN KATEGORI -->

            <div class="category-filter">

                <button
                    type="button"
                    class="category-dropdown-btn"
                    id="categoryDropdownBtn"
                >

                    <span id="selectedCategory">
                        Semua Kategori
                    </span>

                    <i class="fa-solid fa-chevron-down"></i>

                </button>


                <div
                    class="category-dropdown"
                    id="categoryDropdown"
                >

                    <input
                        type="text"
                        id="categorySearch"
                        placeholder="Cari kategori..."
                        autocomplete="off"
                    >


                    <div
                        class="category-list"
                        id="categoryList"
                    >

                        <div
                            class="category-option active"
                            data-category-id="all"
                        >

                            Semua Kategori

                        </div>


                        @foreach($categories as $category)

                            <div
                                class="category-option"
                                data-category-id="{{ $category->id }}"
                            >

                                {{ $category->nama_kategori }}

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            <!-- CETAK SEMUA -->

            <button
                type="button"
                class="print-all-btn"
                id="printAllBarcode"
            >

                <i class="fa-solid fa-print"></i>

                Cetak Semua

            </button>

        </div>

    </div>

    <div class="table-section">

        <table>

            <thead>

                <tr>

                    <th>Produk</th>

                    <th>SKU</th>

                    <th>Barcode</th>

                    <th>Preview</th>

                    <th>Cetak</th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                <tr class="barcode-row"
                    data-category-id="{{ $product->category_id }}">

                    <td>{{ $product->nama_produk }}</td>

                    <td>{{ $product->sku }}</td>

                    <td>{{ $product->barcode }}</td>

                    <td class="barcode-preview">

                        @if($product->barcode)

                            {!! $generator->getBarcode(
                                $product->barcode,
                                $generator::TYPE_CODE_128
                            ) !!}

                            <div class="barcode-number">
                                {{ $product->barcode }}
                            </div>

                        @else

                            <span class="no-barcode">
                                Tidak ada barcode
                            </span>

                        @endif

                    </td>

                    <td>
                        <a href="{{ route('admin.barcode.print', $product->id) }}"
                            class="print-btn">

                            <i class="fa-solid fa-print"></i>

                        </a>
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"
                        class="no-data">

                        Belum ada barcode produk

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

    const searchInput =
        document.getElementById('barcodeSearch');

    const rows =
        document.querySelectorAll('.barcode-row');

    const categoryDropdownBtn =
        document.getElementById('categoryDropdownBtn');

    const categoryDropdown =
        document.getElementById('categoryDropdown');

    const categorySearch =
        document.getElementById('categorySearch');

    const categoryOptions =
        document.querySelectorAll('.category-option');

    const selectedCategory =
        document.getElementById('selectedCategory');


    let selectedCategoryId = 'all';


    /*
    |--------------------------------------------------------------------------
    | BUKA / TUTUP DROPDOWN KATEGORI
    |--------------------------------------------------------------------------
    */

    categoryDropdownBtn.addEventListener('click', function () {

        categoryDropdown.classList.toggle('show');

        if (categoryDropdown.classList.contains('show')) {

            categorySearch.focus();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | TUTUP DROPDOWN KETIKA KLIK DI LUAR
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        if (
            !categoryDropdownBtn.contains(event.target) &&
            !categoryDropdown.contains(event.target)
        ) {

            categoryDropdown.classList.remove('show');

        }

    });


    /*
    |--------------------------------------------------------------------------
    | SEARCH KATEGORI DI DALAM DROPDOWN
    |--------------------------------------------------------------------------
    */

    categorySearch.addEventListener('input', function () {

        const keyword =
            this.value.toLowerCase().trim();


        categoryOptions.forEach(function (option) {

            const categoryName =
                option.textContent
                    .toLowerCase()
                    .trim();


            if (categoryName.includes(keyword)) {

                option.style.display = '';

            } else {

                option.style.display = 'none';

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | FUNGSI FILTER PRODUK
    |--------------------------------------------------------------------------
    */

    function filterProducts() {

        const keyword =
            searchInput.value
                .toLowerCase()
                .trim();


        rows.forEach(function (row) {

            const namaProduk =
                row
                    .querySelector('td:nth-child(1)')
                    .textContent
                    .toLowerCase();

            const sku =
                row
                    .querySelector('td:nth-child(2)')
                    .textContent
                    .toLowerCase();

            const barcode =
                row
                    .querySelector('td:nth-child(3)')
                    .textContent
                    .toLowerCase();


            const categoryId =
                row.dataset.categoryId;


            /*
            |------------------------------------------------------------------
            | CEK SEARCH
            |------------------------------------------------------------------
            */

            const cocokSearch =
                namaProduk.includes(keyword) ||
                sku.includes(keyword) ||
                barcode.includes(keyword);


            /*
            |------------------------------------------------------------------
            | CEK KATEGORI
            |------------------------------------------------------------------
            */

            const cocokKategori =
                selectedCategoryId === 'all' ||
                categoryId === selectedCategoryId;


            /*
            |------------------------------------------------------------------
            | TAMPILKAN / SEMBUNYIKAN
            |------------------------------------------------------------------
            */

            if (
                cocokSearch &&
                cocokKategori
            ) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PILIH KATEGORI
    |--------------------------------------------------------------------------
    */

    categoryOptions.forEach(function (option) {

        option.addEventListener('click', function () {

            selectedCategoryId =
                this.dataset.categoryId;


            selectedCategory.textContent =
                this.textContent.trim();


            categoryOptions.forEach(function (item) {

                item.classList.remove('active');

            });


            this.classList.add('active');


            categoryDropdown.classList.remove('show');


            categorySearch.value = '';


            categoryOptions.forEach(function (item) {

                item.style.display = '';

            });


            filterProducts();

        });

    });


    /*
    |--------------------------------------------------------------------------
    | LIVE SEARCH PRODUK / SKU / BARCODE
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener('input', function () {

        filterProducts();

    });

    /*
    |--------------------------------------------------------------------------
    | CETAK SEMUA BARCODE
    |--------------------------------------------------------------------------
    */

    const printAllButton =
        document.getElementById('printAllBarcode');


    if (printAllButton) {

        printAllButton.addEventListener('click', function () {

            const keyword =
                searchInput.value
                    .trim();


            const params =
                new URLSearchParams();


            /*
            |----------------------------------------------------------------------
            | KIRIM KATEGORI
            |----------------------------------------------------------------------
            */

            if (selectedCategoryId !== 'all') {

                params.append(
                    'category_id',
                    selectedCategoryId
                );

            }


            /*
            |----------------------------------------------------------------------
            | KIRIM SEARCH
            |----------------------------------------------------------------------
            */

            if (keyword !== '') {

                params.append(
                    'search',
                    keyword
                );

            }


            /*
            |----------------------------------------------------------------------
            | BUKA HALAMAN CETAK
            |----------------------------------------------------------------------
            */

            const url =
                "{{ route('admin.barcode.print-all') }}" +
                (
                    params.toString()
                        ? '?' + params.toString()
                        : ''
                );


            window.open(
                url,
                '_blank'
            );

        });

    }

});

</script>

@endsection