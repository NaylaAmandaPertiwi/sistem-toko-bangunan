@extends('layouts.admin')

@section('title', 'Produk')

@section('content')

<style>

/* ==========================================================
   PAGE
========================================================== */

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}


/* ==========================================================
   TOP HEADER
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
}

.filter-row{
    width:100%;
    display:grid;
    grid-template-columns:215px minmax(250px, 1fr) auto;
    gap:15px;
    align-items:center;
}


/* ==========================================================
   CATEGORY DROPDOWN
========================================================== */

.category-dropdown{
    position:relative;
    width:100%;
}

.category-dropdown-btn{
    width:100%;
    height:48px;

    background:white;
    border:1px solid #ddd;
    border-radius:10px;

    padding:0 15px;

    display:flex;
    align-items:center;
    justify-content:space-between;

    cursor:pointer;

    font-size:14px;
    color:#222;

    box-sizing:border-box;
}

.category-dropdown-btn:hover{
    border-color:#1684e0;
}

.category-dropdown-btn i{
    color:#777;
    font-size:12px;
}

.category-dropdown-menu{
    position:absolute;

    top:55px;
    left:0;

    width:100%;

    background:white;

    border:1px solid #ddd;
    border-radius:10px;

    box-shadow:0 8px 20px rgba(0,0,0,.12);

    display:none;

    z-index:1000;

    overflow:hidden;
}

.category-dropdown-menu.show{
    display:block;
}

.category-search{
    padding:10px;
    border-bottom:1px solid #eee;
}

.category-search input{
    width:100%;
    height:38px;

    padding:0 12px;

    border:1px solid #ddd;
    border-radius:8px;

    box-sizing:border-box;

    outline:none;

    font-size:13px;
}

.category-search input:focus{
    border-color:#1684e0;
}

.category-options{
    max-height:220px;
    overflow-y:auto;
}

.category-option{
    width:100%;

    border:none;
    background:white;

    padding:11px 14px;

    text-align:left;

    cursor:pointer;

    font-size:14px;
    color:#222;
}

.category-option:hover{
    background:#f3f6fb;
}

.category-option.active{
    background:#eef5ff;
    color:#1684e0;
    font-weight:600;
}

.category-no-result{
    padding:15px;

    text-align:center;

    color:#999;

    font-size:13px;
}


/* ==========================================================
   PRODUCT SEARCH
========================================================== */

.product-search{
    width:100%;
}

.product-search input{
    width:100%;
    height:48px;

    padding:0 16px;

    border:1px solid #ddd;
    border-radius:10px;

    box-sizing:border-box;

    outline:none;

    font-size:14px;
}

.product-search input:focus{
    border-color:#1684e0;
}


/* ==========================================================
   ADD BUTTON
========================================================== */

.add-btn{
    height:48px;

    background:#1684e0;
    color:white;

    border:none;

    padding:0 22px;

    border-radius:10px;

    cursor:pointer;

    font-size:15px;

    text-decoration:none;

    display:flex;
    align-items:center;
    justify-content:center;

    white-space:nowrap;

    transition:.2s;
}

.add-btn:hover{
    background:#0d75c9;

    color:white;

    text-decoration:none;
}


/* ==========================================================
   TABLE
========================================================== */

.table-section{
    padding:0 25px 25px 25px;
}

.table-wrapper{
    width:100%;

    overflow-x:auto;

    border-radius:12px;
}


/*
|--------------------------------------------------------------------------
| Jangan gunakan min-width:1200px lagi
|--------------------------------------------------------------------------
*/

table{
    width:100%;

    border-collapse:collapse;

    background:white;

    table-layout:auto;
}

table th{
    background:#f3f5fa;

    padding:14px 10px;

    text-align:left;

    white-space:nowrap;

    font-size:14px;
}

table td{
    padding:13px 10px;

    border-bottom:1px solid #eee;

    font-size:14px;

    vertical-align:middle;
}

table tbody tr:last-child td{
    border-bottom:none;
}

table tbody tr:hover{
    background:#fafcff;
}

.no-data{
    text-align:center;

    padding:40px;

    color:#999;
}


/* ==========================================================
   STATUS
========================================================== */

.status-active{
    background:#d1fae5;

    color:#065f46;

    padding:6px 12px;

    border-radius:20px;

    font-size:12px;

    font-weight:600;

    white-space:nowrap;
}

.status-inactive{
    background:#fee2e2;

    color:#991b1b;

    padding:6px 12px;

    border-radius:20px;

    font-size:12px;

    font-weight:600;

    white-space:nowrap;
}


/* ==========================================================
   ACTION
========================================================== */

.action-wrapper{
    display:flex;

    align-items:center;

    gap:12px;
}

.edit-btn{
    border:none;

    background:none;

    color:#1684e0;

    cursor:pointer;

    font-size:17px;

    text-decoration:none;
}

.edit-btn:hover{
    color:#0d6ebd;
}

.delete-btn{
    border:none;

    background:none;

    color:#dc3545;

    cursor:pointer;

    font-size:17px;

    padding:0;
}

.delete-btn:hover{
    color:#b02a37;
}


/* ==========================================================
   TABLE FOOTER
========================================================== */

.table-footer{
    margin-top:18px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    gap:15px;
}

.footer-left,
.footer-right{
    display:flex;

    align-items:center;

    gap:14px;
}

.footer-left select{
    padding:8px 12px;

    border:1px solid #ddd;

    border-radius:8px;
}

.footer-right button{
    border:none;

    background:none;

    cursor:pointer;

    color:#666;
}

.footer-right input{
    width:60px;

    padding:8px;

    border:1px solid #ddd;

    border-radius:8px;

    text-align:center;
}

.page-active{
    color:#1684e0;

    font-weight:600;
}


/* ==========================================================
   RESPONSIVE
========================================================== */

@media(max-width:900px){

    .filter-row{
        grid-template-columns:1fr;
    }

    .add-btn{
        width:100%;
    }

}

</style>


<div class="page-header">


    {{-- ======================================================
         HEADER
    ======================================================= --}}

    <div class="top-header">

        Produk

    </div>


    {{-- ======================================================
         FILTER
    ======================================================= --}}

    <div class="filter-section">

        <div class="filter-row">


            {{-- ==================================================
                 DROPDOWN KATEGORI
            =================================================== --}}

            <div class="category-dropdown">

                <button
                    type="button"
                    class="category-dropdown-btn"
                    id="categoryDropdownButton">

                    <span id="selectedCategoryText">

                        Semua Kategori

                    </span>

                    <i class="fa-solid fa-chevron-down"></i>

                </button>


                <div
                    class="category-dropdown-menu"
                    id="categoryDropdownMenu">


                    {{-- SEARCH KATEGORI --}}

                    <div class="category-search">

                        <input
                            type="text"
                            id="categorySearch"
                            placeholder="Cari kategori..."
                            autocomplete="off">

                    </div>


                    {{-- OPTIONS --}}

                    <div
                        class="category-options"
                        id="categoryOptions">


                        {{-- SEMUA KATEGORI --}}

                        <button
                            type="button"
                            class="category-option active"
                            data-value="">

                            Semua Kategori

                        </button>


                        @foreach($categories as $category)

                            <button
                                type="button"
                                class="category-option"
                                data-value="{{ $category->id }}"
                                data-name="{{ strtolower($category->nama_kategori) }}">

                                {{ $category->nama_kategori }}

                            </button>

                        @endforeach


                    </div>


                    <div
                        class="category-no-result"
                        id="categoryNoResult"
                        style="display:none;">

                        Kategori tidak ditemukan

                    </div>


                </div>

            </div>


            {{-- ==================================================
                 SEARCH PRODUK
            =================================================== --}}

            <div class="product-search">

                <input
                    type="text"
                    id="productSearch"
                    placeholder="Cari Produk"
                    autocomplete="off">

            </div>


            {{-- ==================================================
                 TAMBAH PRODUK
            =================================================== --}}

            <a
                href="{{ route('admin.produk.create') }}"
                class="add-btn">

                Tambah Produk

            </a>


        </div>

    </div>


    {{-- ======================================================
         TABLE
    ======================================================= --}}

    <div class="table-section">


        <div class="table-wrapper">

            <table id="productTable">

                <thead>

                    <tr>

                        <th width="35">

                            <input
                                type="checkbox"
                                id="checkAll">

                        </th>


                        <th>

                            Nama Produk

                        </th>


                        <th>
                            Kategori
                        </th>

                        <th>
                            SKU
                        </th>

                        <th>
                            Barcode
                        </th>

                        <th>
                            Qty Stok
                        </th>

                        <th>
                            Stok Minimum
                        </th>

                        <th>
                            Satuan
                        </th>

                        <th>

                            Harga Beli

                        </th>


                        <th>

                            Harga Jual

                        </th>


                        <th>

                            Status

                        </th>


                        <th>

                            Aksi

                        </th>

                    </tr>

                </thead>


                <tbody id="productTableBody">


                    @forelse($products as $product)

                        <tr
                            class="product-row"
                            data-category="{{ $product->category_id }}"
                            data-search="{{ strtolower(
                                $product->nama_produk . ' ' .
                                ($product->category->nama_kategori ?? '') . ' ' .
                                ($product->sku ?? '') . ' ' .
                                ($product->barcode ?? '')
                            ) }}">


                            {{-- CHECKBOX --}}

                            <td>

                                <input
                                    type="checkbox"
                                    class="product-checkbox"
                                    value="{{ $product->id }}">

                            </td>


                            {{-- NAMA PRODUK --}}

                            <td>

                                {{ $product->nama_produk }}

                            </td>


                            {{-- KATEGORI --}}

                            <td>

                                {{ $product->category->nama_kategori ?? '-' }}

                            </td>


                            {{-- SKU --}}

                            <td>

                                {{ $product->sku ?? '-' }}

                            </td>


                            {{-- BARCODE --}}

                            <td>

                                {{ $product->barcode ?? '-' }}

                            </td>


                            {{-- STOK --}}

                            <td>

                                {{ $product->stok }}

                            </td>


                            {{-- STOK MINIMUM --}}

                            <td>

                                {{ $product->stok_minimum }}

                            </td>


                            {{-- SATUAN --}}

                            <td>

                                {{ $product->satuan }}

                            </td>


                            {{-- HARGA BELI --}}

                            <td>

                                Rp {{ number_format(
                                    $product->harga_beli,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- HARGA JUAL --}}

                            <td>

                                Rp {{ number_format(
                                    $product->harga_jual,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if($product->status == 'Aktif')

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

                                <div class="action-wrapper">

                                    <a
                                        href="{{ route(
                                            'admin.produk.edit',
                                            $product->id
                                        ) }}"
                                        class="edit-btn">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr id="noProductData">

                            <td
                                colspan="12"
                                class="no-data">

                                Belum ada produk

                            </td>

                        </tr>

                    @endforelse


                    {{-- TIDAK DITEMUKAN SAAT LIVE SEARCH --}}

                    <tr
                        id="noSearchResult"
                        style="display:none;">

                        <td
                            colspan="12"
                            class="no-data">

                            Produk tidak ditemukan

                        </td>

                    </tr>


                </tbody>

            </table>

        </div>


        {{-- ==================================================
             FOOTER
        =================================================== --}}

        <div class="table-footer">


            <div class="footer-left">

                <button
                    type="button"
                    class="delete-btn"
                    onclick="bulkDelete()">

                    <i class="fa-regular fa-trash-can"></i>

                </button>


                <select>

                    <option>10/page</option>

                    <option>25/page</option>

                    <option>50/page</option>

                </select>


                <span id="totalProduct">

                    Total {{ $products->count() }}

                </span>


            </div>


            <div class="footer-right">

                <button type="button">

                    <i class="fa-solid fa-chevron-left"></i>

                </button>


                <span class="page-active">

                    1

                </span>


                <button type="button">

                    <i class="fa-solid fa-chevron-right"></i>

                </button>


                <span>

                    Go to

                </span>


                <input
                    type="number"
                    value="1">

            </div>


        </div>


    </div>


</div>


{{-- ==========================================================
     BULK DELETE FORM
=========================================================== --}}

<form
    id="bulkDeleteForm"
    action="{{ route('admin.produk.bulkDelete') }}"
    method="POST"
    style="display:none;">

    @csrf

    @method('DELETE')

    <input
        type="hidden"
        name="ids"
        id="selectedIds">

</form>


<script>


/* ==========================================================
   ELEMENT
========================================================== */

const categoryDropdownButton =
    document.getElementById('categoryDropdownButton');

const categoryDropdownMenu =
    document.getElementById('categoryDropdownMenu');

const categorySearch =
    document.getElementById('categorySearch');

const categoryOptions =
    document.querySelectorAll('.category-option');

const selectedCategoryText =
    document.getElementById('selectedCategoryText');

const categoryNoResult =
    document.getElementById('categoryNoResult');

const productSearch =
    document.getElementById('productSearch');

const productRows =
    document.querySelectorAll('.product-row');

const noSearchResult =
    document.getElementById('noSearchResult');

const totalProduct =
    document.getElementById('totalProduct');


let selectedCategory = '';



/* ==========================================================
   CATEGORY DROPDOWN
========================================================== */

categoryDropdownButton.addEventListener(
    'click',
    function(e){

        e.stopPropagation();

        categoryDropdownMenu.classList.toggle('show');

        if(
            categoryDropdownMenu
            .classList
            .contains('show')
        ){

            categorySearch.focus();

        }

    }
);



/* Jangan tutup ketika klik isi dropdown */

categoryDropdownMenu.addEventListener(
    'click',
    function(e){

        e.stopPropagation();

    }
);



/* Tutup ketika klik di luar */

document.addEventListener(
    'click',
    function(){

        categoryDropdownMenu
            .classList
            .remove('show');

    }
);



/* ==========================================================
   LIVE SEARCH KATEGORI
========================================================== */

categorySearch.addEventListener(
    'input',
    function(){

        const keyword =
            this.value
                .toLowerCase()
                .trim();

        let found = 0;


        categoryOptions.forEach(
            function(option){

                const text =
                    option
                        .textContent
                        .toLowerCase()
                        .trim();


                if(
                    text.includes(keyword)
                ){

                    option.style.display =
                        'block';

                    found++;

                }else{

                    option.style.display =
                        'none';

                }

            }
        );


        if(found === 0){

            categoryNoResult.style.display =
                'block';

        }else{

            categoryNoResult.style.display =
                'none';

        }

    }
);



/* ==========================================================
   PILIH KATEGORI
========================================================== */

categoryOptions.forEach(
    function(option){

        option.addEventListener(
            'click',
            function(){

                selectedCategory =
                    this.dataset.value;


                selectedCategoryText.textContent =
                    this.textContent.trim();


                categoryOptions.forEach(
                    function(item){

                        item.classList.remove(
                            'active'
                        );

                    }
                );


                this.classList.add('active');


                categoryDropdownMenu
                    .classList
                    .remove('show');


                categorySearch.value = '';


                categoryOptions.forEach(
                    function(item){

                        item.style.display =
                            'block';

                    }
                );


                categoryNoResult.style.display =
                    'none';


                filterProducts();

            }
        );

    }
);



/* ==========================================================
   LIVE SEARCH PRODUK
========================================================== */

productSearch.addEventListener(
    'input',
    function(){

        filterProducts();

    }
);



/* ==========================================================
   FILTER PRODUK
========================================================== */

function filterProducts()
{

    const keyword =
        productSearch.value
            .toLowerCase()
            .trim();


    let visibleCount = 0;


    productRows.forEach(
        function(row){

            const rowCategory =
                row.dataset.category;


            const rowSearch =
                row.dataset.search;


            const categoryMatch =
                selectedCategory === '' ||
                rowCategory === selectedCategory;


            const searchMatch =
                keyword === '' ||
                rowSearch.includes(keyword);


            if(
                categoryMatch &&
                searchMatch
            ){

                row.style.display =
                    '';

                visibleCount++;

            }else{

                row.style.display =
                    'none';

            }

        }
    );


    /* ======================================================
       HASIL TIDAK DITEMUKAN
    ======================================================= */

    if(visibleCount === 0){

        noSearchResult.style.display =
            '';

    }else{

        noSearchResult.style.display =
            'none';

    }


    /* ======================================================
       TOTAL DATA
    ======================================================= */

    totalProduct.textContent =
        'Total ' + visibleCount;

}



/* ==========================================================
   CHECK ALL
========================================================== */

const checkAll =
    document.getElementById('checkAll');


checkAll.addEventListener(
    'change',
    function(){

        productRows.forEach(
            function(row){

                if(
                    row.style.display !== 'none'
                ){

                    const checkbox =
                        row.querySelector(
                            '.product-checkbox'
                        );

                    checkbox.checked =
                        checkAll.checked;

                }

            }
        );

    }
);



/* ==========================================================
   BULK DELETE
========================================================== */

function bulkDelete()
{

    let ids = [];


    document
        .querySelectorAll(
            '.product-checkbox:checked'
        )
        .forEach(
            function(item){

                ids.push(item.value);

            }
        );


    if(ids.length === 0){

        alert(
            'Pilih produk terlebih dahulu'
        );

        return;

    }


    if(
        confirm(
            'Hapus produk yang dipilih?'
        )
    ){

        document.getElementById(
            'selectedIds'
        ).value = ids.join(',');


        document.getElementById(
            'bulkDeleteForm'
        ).submit();

    }

}


</script>

@endsection