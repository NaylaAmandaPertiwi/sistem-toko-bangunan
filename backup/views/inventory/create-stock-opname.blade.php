@extends('layouts.app')

@section('title','Tambah Stok Opname')

@section('content')

<style>

.page-card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
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
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.section-title{
    color:#57c13b;
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

.stock-input{
    width:100px;
    padding:8px;
    border:1px solid #ddd;
    border-radius:8px;
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

/* Select2 */
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

</style>

</style>

<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>Tambah Stok Opname</h2>

            <div>

                <a href="{{ route('stok-opname.index') }}"
                   class="btn-cancel">
                    Batal
                </a>

                <button
                    type="submit"
                    form="opnameForm"
                    class="btn-save">
                    Simpan
                </button>

            </div>

        </div>

    </div>

    <div class="form-body">

        <form
            id="opnameForm"
            action="{{ route('stok-opname.store') }}"
            method="POST"
            onsubmit="return validateOpname()">

            @csrf

            <h3 class="section-title">
                Informasi Opname
            </h3>

            <div class="form-group">
                <label>No Opname</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ 'SO-' . now()->format('YmdHis') }}"
                    readonly>
            </div>

            <div class="form-group">
                <label>Tanggal Opname</label>
                <input
                    type="date"
                    name="tanggal_opname"
                    class="form-control"
                    value="{{ date('Y-m-d') }}"
                    required>
            </div>

            <div class="form-group">

                <label>Petugas</label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ auth()->user()->name }}"
                    readonly>

                <input
                    type="hidden"
                    name="petugas"
                    value="{{ auth()->user()->name }}">

            </div>

            <div class="form-group">
                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="Draft">
                        Draft
                    </option>

                    <option value="Disetujui">
                        Disetujui
                    </option>

                    <option value="Selesai">
                        Selesai
                    </option>

                    <option value="Dibatalkan">
                        Dibatalkan
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea
                    name="keterangan"
                    rows="3"
                    class="form-control"></textarea>
            </div>

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

                            <th>Produk</th>
                            <th>SKU</th>
                            <th>Stok Sistem</th>
                            <th>Stok Fisik</th>
                            <th>Selisih</th>
                            <th width="100">Aksi</th>

                        </tr>

                    </thead>

                    <tbody id="productBody">

                    </tbody>

                </table>

            </div>

        </form>

    </div>

</div>

<div id="productModal" class="modal">

    <div class="modal-content">

        <h3>Tambah Produk</h3>

        <div class="form-group">

            <label>Produk</label>

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

            <label>SKU</label>

            <input
                type="text"
                id="modalSku"
                class="form-control"
                readonly>

        </div>

        <div class="form-group">

            <label>Stok Sistem</label>

            <input
                type="number"
                id="modalStokSistem"
                class="form-control"
                readonly>

        </div>

        <div class="form-group">

            <label>Stok Fisik</label>

            <input
                type="number"
                id="modalStokFisik"
                class="form-control">

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

<script>

let rowIndex = 0;

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

    document.getElementById('modalProduct').value = '';
    document.getElementById('modalSku').value = '';
    document.getElementById('modalStokSistem').value = '';
    document.getElementById('modalStokFisik').value = '';

    $('#modalProduct').val(null).trigger('change');
}

window.onclick = function(event)
{
    let modal =
        document.getElementById(
            'productModal'
        );

    if(event.target == modal)
    {
        closeModal();
    }
}

function loadProductData()
{
    let select =
        document.getElementById('modalProduct');

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

function saveProduct()
{
    let productSelect =
        document.getElementById('modalProduct');

    let selectedProduct =
    productSelect.value;

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
        alert('Produk sudah ditambahkan');
        return;
    }

    if(productSelect.value == '')
    {
        alert('Pilih produk terlebih dahulu');
        return;
    }


    let option =
        productSelect.options[
            productSelect.selectedIndex
        ];

    let stokSistem =
        document.getElementById('modalStokSistem')
        .value;

    let stokFisik =
        document.getElementById('modalStokFisik')
        .value;

    if(stokFisik == '')
    {
        alert('Isi stok fisik');
        return;
    }

    let selisih =
        parseInt(stokFisik)
        -
        parseInt(stokSistem);

    let tbody =
        document.getElementById('productBody');

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

    document.getElementById('modalProduct').value='';
    document.getElementById('modalSku').value='';
    document.getElementById('modalStokSistem').value='';
    document.getElementById('modalStokFisik').value='';

    closeModal();
}

function editRow(button)
{
    let row =
        button.closest('tr');

    let stokFisikCell =
        row.children[3];

    let nilai =
        stokFisikCell.innerText.trim();

    let input =
        prompt(
            'Ubah stok fisik',
            nilai
        );

    if(input === null)
    {
        return;
    }

    if(isNaN(input) || input < 0)
    {
        alert('Stok fisik harus berupa angka dan tidak boleh negatif');
        return;
    }

    // VALIDASI TAMBAHAN
    if(isNaN(input) || input < 0)
    {
        alert('Stok fisik harus berupa angka dan tidak boleh negatif');
        return;
    }

    stokFisikCell.innerHTML =
        input +
        `<input
            type="hidden"
            name="${
                row.querySelector(
                'input[name*="[stok_fisik]"]'
                ).name
            }"
            value="${input}">`;

    let stokSistem =
        parseInt(
            row.children[2]
            .innerText
        );

    let selisih =
        parseInt(input)
        - stokSistem;

    row.children[4]
        .innerText =
        selisih;
}

function removeRow(button)
{
    button
    .closest('tr')
    .remove();
}

function validateOpname()
{
    let totalRow =
        document.querySelectorAll(
            '#productBody tr'
        ).length;

    if(totalRow == 0)
    {
        alert(
            'Minimal harus ada 1 produk'
        );

        return false;
    }

    return true;
}

document
.addEventListener(
'DOMContentLoaded',
function(){

    $('#modalProduct')
    .select2({
        dropdownParent:
        $('#productModal')
    });

});

</script>

@endsection