@extends('layouts.admin')

@section('title','Edit Stok Opname')

@section('content')

<style>

.opname-edit-card{
    width:100%;
    max-width:100%;
    margin:0;
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
    color:#222;
    box-sizing:border-box;
}

.page-header{
    padding:25px;
    border-bottom:1px solid #eee;
}

.page-title{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.page-title h2{
    margin:0;
    font-size:32px;
    color:#222 !important;
}

.btn-save{
    background:#57c13b;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:10px;
    cursor:pointer;
}

.btn-danger{
    background:#dc3545;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:10px;
    cursor:pointer;
}

.btn-cancel{
    text-decoration:none;
    color:#1684e0;
    margin-right:15px;
}

.form-body{
    padding:30px;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
    color:#222 !important;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.section-title{
    color:#57c13b !important;
    margin-bottom:20px;
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
}

.stock-table td{
    padding:12px;
    border-bottom:1px solid #eee;
}

.product-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.remove-btn{
    border:none;
    background:none;
    cursor:pointer;
    font-size:16px;
    margin-right:5px;
}

.edit-btn{
    color:#1684e0;
}

.delete-btn{
    color:#dc3545;
}

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.4);
    z-index:9999;
}

.modal-content{
    background:white;
    width:1000px;
    max-width:95%;
    margin:50px auto;
    padding:35px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,.15);
}

.select2-container{
    width:100% !important;
}

.select2-selection{
    height:45px !important;
    border-radius:10px !important;
    border:1px solid #ddd !important;
}

.select2-selection__rendered{
    line-height:45px !important;
    white-space:nowrap !important;
}

.select2-selection__arrow{
    height:45px !important;
}

.select2-results__option{
    white-space:nowrap;
}

.modal-content h3{
    margin-bottom:25px;
    font-size:28px;
}

.modal-content .form-group{
    margin-bottom:18px;
}

.stock-input{
    width:100px;
    padding:8px;
    border:1px solid #ddd;
    border-radius:8px;
}

</style>


<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>
                Edit Stok Opname
            </h2>

            <div>

                <a
                    href="{{ route('admin.stok-opname.show', $opname->id) }}"
                    class="btn-cancel">

                    Batal

                </a>

                <button
                    type="submit"
                    form="opnameForm"
                    class="btn-save">

                    Simpan Perubahan

                </button>

            </div>

        </div>

    </div>


    <div class="form-body">

        @if ($errors->any())

        <div style="
            background:#ffe5e5;
            color:#b91c1c;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        ">

            <b>Terjadi kesalahan:</b>

            <ul style="margin-top:10px;margin-left:20px;">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif


        <form
            id="opnameForm"
            action="{{ route('admin.stok-opname.update', $opname->id) }}"
            method="POST"
            onsubmit="return validateOpname()">

            @csrf

            @method('PUT')


            {{-- ==========================================================
                 INFORMASI OPNAME
            =========================================================== --}}

            <h3 class="section-title">
                Informasi Opname
            </h3>


            <div class="form-group">

                <label>
                    No Opname
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $opname->nomor_opname }}"
                    readonly>

            </div>


            <div class="form-group">

                <label>
                    Tanggal Opname
                </label>

                <input
                    type="date"
                    name="tanggal_opname"
                    class="form-control"
                    value="{{ old(
                        'tanggal_opname',
                        $opname->tanggal_opname
                    ) }}"
                    required>

            </div>


            <div class="form-group">

                <label>
                    Petugas
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $opname->petugas }}"
                    readonly>

                <input
                    type="hidden"
                    name="petugas"
                    value="{{ $opname->petugas }}">

            </div>


            <div class="form-group">

                <label>
                    Status
                </label>

                {{-- Draft sengaja dikunci --}}
                <input
                    type="text"
                    class="form-control"
                    value="Draft"
                    readonly>

                <input
                    type="hidden"
                    name="status"
                    value="Draft">

            </div>


            <div class="form-group">

                <label>
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    rows="3"
                    class="form-control">{{ old(
                        'keterangan',
                        $opname->keterangan
                    ) }}</textarea>

            </div>


            {{-- ==========================================================
                 DETAIL PRODUK
            =========================================================== --}}

            <div class="product-header">

                <h3 class="section-title">

                    Detail Produk

                </h3>


                <button
                    type="button"
                    class="btn-save"
                    onclick="openModal()">

                    <i class="fa-solid fa-plus"></i>

                    Tambah Produk

                </button>

            </div>


            <div class="table-wrapper">

                <table class="stock-table">

                    <thead>

                        <tr>

                            <th>
                                Produk
                            </th>

                            <th>
                                SKU
                            </th>

                            <th>
                                Stok Sistem
                            </th>

                            <th>
                                Stok Fisik
                            </th>

                            <th>
                                Selisih
                            </th>

                            <th width="100">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody id="productBody">


                    @foreach(
                        $opname->details
                        as $detail
                    )

                    <tr>

                        <td>

                            {{ $detail->product->nama_produk }}

                            <input
                                type="hidden"
                                name="products[{{ $loop->index }}][product_id]"
                                value="{{ $detail->product_id }}">

                        </td>


                        <td>

                            {{ $detail->product->sku }}

                        </td>


                        <td>

                            {{ $detail->stok_sistem }}

                            <input
                                type="hidden"
                                name="products[{{ $loop->index }}][stok_sistem]"
                                value="{{ $detail->stok_sistem }}">

                        </td>


                        <td>

                            {{ $detail->stok_fisik }}

                            <input
                                type="hidden"
                                name="products[{{ $loop->index }}][stok_fisik]"
                                value="{{ $detail->stok_fisik }}">

                        </td>


                        <td>

                            {{ $detail->selisih }}

                        </td>


                        <td>

                            <button
                                type="button"
                                class="remove-btn edit-btn"
                                onclick="editRow(this)">

                                <i class="fa-solid fa-pen"></i>

                            </button>


                            <button
                                type="button"
                                class="remove-btn delete-btn"
                                onclick="removeRow(this)">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </td>

                    </tr>

                    @endforeach


                    </tbody>

                </table>

            </div>

        </form>

    </div>

</div>



{{-- ==============================================================
     MODAL TAMBAH PRODUK
================================================================ --}}

<div
    id="productModal"
    class="modal">

    <div class="modal-content">

        <h3>
            Tambah Produk
        </h3>


        <div class="form-group">

            <label>
                Produk
            </label>

            <select
                id="modalProduct"
                class="form-control"
                onchange="loadProductData()">

                <option value="">
                    Pilih Produk
                </option>


                @foreach($products as $product)

                <option
                    value="{{ $product->id }}"
                    data-sku="{{ $product->sku }}"
                    data-stok="{{ $product->stok }}">

                    {{ $product->nama_produk }}

                </option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label>
                SKU
            </label>

            <input
                type="text"
                id="modalSku"
                class="form-control"
                readonly>

        </div>


        <div class="form-group">

            <label>
                Stok Sistem
            </label>

            <input
                type="number"
                id="modalStokSistem"
                class="form-control"
                readonly>

        </div>


        <div class="form-group">

            <label>
                Stok Fisik
            </label>

            <input
                type="number"
                id="modalStokFisik"
                class="form-control"
                min="0">

        </div>


        <div style="text-align:right">

            <button
                type="button"
                class="btn-danger"
                onclick="closeModal()">

                Batal

            </button>


            <button
                type="button"
                class="btn-save"
                onclick="saveProduct()">

                Simpan

            </button>

        </div>

    </div>

</div>



{{-- ==============================================================
     MODAL EDIT PRODUK
================================================================ --}}

<div
    id="editModal"
    class="modal">

    <div class="modal-content">

        <h3>
            Edit Stok Fisik
        </h3>


        <div class="form-group">

            <label>
                Produk
            </label>

            <input
                type="text"
                id="editNamaProduk"
                class="form-control"
                readonly>

        </div>


        <div class="form-group">

            <label>
                Stok Sistem
            </label>

            <input
                type="number"
                id="editStokSistem"
                class="form-control"
                readonly>

        </div>


        <div class="form-group">

            <label>
                Stok Fisik
            </label>

            <input
                type="number"
                id="editStokFisik"
                class="form-control"
                min="0">

        </div>


        <div style="text-align:right">

            <button
                type="button"
                class="btn-danger"
                onclick="closeEditModal()">

                Batal

            </button>


            <button
                type="button"
                class="btn-save"
                onclick="saveEditProduct()">

                Simpan

            </button>

        </div>

    </div>

</div>



@section('scripts')

<script>

let rowIndex =
    {{ $opname->details->count() }};

let currentEditRow = null;


/*
|--------------------------------------------------------------------------
| MODAL TAMBAH PRODUK
|--------------------------------------------------------------------------
*/

function openModal()
{
    document
        .getElementById('productModal')
        .style.display = 'block';
}


function closeModal()
{
    document
        .getElementById('productModal')
        .style.display = 'none';

    document
        .getElementById('modalProduct')
        .value = '';

    document
        .getElementById('modalSku')
        .value = '';

    document
        .getElementById('modalStokSistem')
        .value = '';

    document
        .getElementById('modalStokFisik')
        .value = '';

    $('#modalProduct')
        .val(null)
        .trigger('change');
}


function loadProductData()
{
    let select =
        document.getElementById(
            'modalProduct'
        );

    let option =
        select.options[
            select.selectedIndex
        ];

    document
        .getElementById('modalSku')
        .value =
            option.dataset.sku || '';

    document
        .getElementById('modalStokSistem')
        .value =
            option.dataset.stok || 0;
}



/*
|--------------------------------------------------------------------------
| TAMBAH PRODUK
|--------------------------------------------------------------------------
*/

function saveProduct()
{
    let productSelect =
        document.getElementById(
            'modalProduct'
        );

    let selectedProduct =
        productSelect.value;


    if(selectedProduct == '')
    {
        showToast(
            'Silakan pilih produk terlebih dahulu.',
            'warning'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Cek produk sudah ada
    |--------------------------------------------------------------------------
    */

    let exists = false;

    document
        .querySelectorAll(
            'input[name*="[product_id]"]'
        )
        .forEach(function(item){

            if(item.value == selectedProduct)
            {
                exists = true;
            }

        });


    if(exists)
    {
        showToast(
            'Produk sudah ditambahkan.',
            'warning'
        );

        return;
    }


    let option =
        productSelect.options[
            productSelect.selectedIndex
        ];


    let stokSistem =
        document
            .getElementById(
                'modalStokSistem'
            )
            .value;


    let stokFisik =
        document
            .getElementById(
                'modalStokFisik'
            )
            .value;


    if(
        stokFisik == '' ||
        isNaN(stokFisik) ||
        stokFisik < 0
    )
    {
        showToast(
            'Stok fisik tidak valid.',
            'warning'
        );

        return;
    }


    let selisih =
        parseInt(stokFisik)
        -
        parseInt(stokSistem);


    let tbody =
        document.getElementById(
            'productBody'
        );


    tbody.insertAdjacentHTML(
        'beforeend',
        `
        <tr>

            <td>

                ${option.text}

                <input
                    type="hidden"
                    name="products[${rowIndex}][product_id]"
                    value="${option.value}">

            </td>


            <td>

                ${option.dataset.sku}

            </td>


            <td>

                ${stokSistem}

                <input
                    type="hidden"
                    name="products[${rowIndex}][stok_sistem]"
                    value="${stokSistem}">

            </td>


            <td>

                ${stokFisik}

                <input
                    type="hidden"
                    name="products[${rowIndex}][stok_fisik]"
                    value="${stokFisik}">

            </td>


            <td>

                ${selisih}

            </td>


            <td>

                <button
                    type="button"
                    class="remove-btn edit-btn"
                    onclick="editRow(this)">

                    <i class="fa-solid fa-pen"></i>

                </button>


                <button
                    type="button"
                    class="remove-btn delete-btn"
                    onclick="removeRow(this)">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </td>

        </tr>
        `
    );


    rowIndex++;

    closeModal();
}



/*
|--------------------------------------------------------------------------
| EDIT PRODUK
|--------------------------------------------------------------------------
*/

function editRow(button)
{
    currentEditRow =
        button.closest('tr');


    document
        .getElementById(
            'editNamaProduk'
        )
        .value =
            currentEditRow
                .children[0]
                .innerText
                .trim();


    document
        .getElementById(
            'editStokSistem'
        )
        .value =
            currentEditRow
                .querySelector(
                    'input[name*="[stok_sistem]"]'
                )
                .value;


    document
        .getElementById(
            'editStokFisik'
        )
        .value =
            currentEditRow
                .querySelector(
                    'input[name*="[stok_fisik]"]'
                )
                .value;


    document
        .getElementById(
            'editModal'
        )
        .style.display = 'block';
}


function closeEditModal()
{
    document
        .getElementById(
            'editModal'
        )
        .style.display = 'none';

    currentEditRow = null;
}


function saveEditProduct()
{
    if(currentEditRow == null)
    {
        return;
    }


    let stokFisik =
        document
            .getElementById(
                'editStokFisik'
            )
            .value;


    if(
        stokFisik == '' ||
        isNaN(stokFisik) ||
        stokFisik < 0
    )
    {
        showToast(
            'Stok fisik tidak valid.',
            'warning'
        );

        return;
    }


    let stokSistem =
        parseInt(
            document
                .getElementById(
                    'editStokSistem'
                )
                .value
        );


    let selisih =
        parseInt(stokFisik)
        -
        stokSistem;


    let stokFisikInput =
        currentEditRow
            .querySelector(
                'input[name*="[stok_fisik]"]'
            );


    stokFisikInput.value =
        stokFisik;


    currentEditRow
        .children[3]
        .childNodes[0]
        .textContent =
            stokFisik;


    currentEditRow
        .children[4]
        .innerText =
            selisih;


    closeEditModal();
}



/*
|--------------------------------------------------------------------------
| HAPUS PRODUK DARI FORM
|--------------------------------------------------------------------------
*/

function removeRow(button)
{
    button
        .closest('tr')
        .remove();
}



/*
|--------------------------------------------------------------------------
| VALIDASI FORM
|--------------------------------------------------------------------------
*/

function validateOpname()
{
    let totalRow =
        document.querySelectorAll(
            '#productBody tr'
        ).length;


    if(totalRow == 0)
    {
        showToast(
            'Minimal harus ada satu produk.',
            'warning'
        );

        return false;
    }


    return true;
}



/*
|--------------------------------------------------------------------------
| TUTUP MODAL KETIKA KLIK DI LUAR
|--------------------------------------------------------------------------
*/

window.onclick =
function(event)
{
    let productModal =
        document.getElementById(
            'productModal'
        );

    let editModal =
        document.getElementById(
            'editModal'
        );


    if(event.target == productModal)
    {
        closeModal();
    }


    if(event.target == editModal)
    {
        closeEditModal();
    }
};



/*
|--------------------------------------------------------------------------
| SELECT2
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function(){

        $('#modalProduct').select2({

            dropdownParent:
                $('#productModal')

        });

    }
);

</script>

@endsection