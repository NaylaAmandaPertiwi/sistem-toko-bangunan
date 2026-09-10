@extends('layouts.admin')

@section('title','Tambah Produk')

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
    font-size:34px;
    margin:0;
}

.btn-save{
    background:#57c13b;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:8px;
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

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:30px;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
    color:#444;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:14px;
}

.form-control:focus{
    outline:none;
    border-color:#1684e0;
}

.section-title{
    color:#57c13b;
    font-size:22px;
    margin-bottom:20px;
}

.category-search{
    position:relative;
}

.category-results{
    position:absolute;
    top:100%;
    left:0;
    right:0;
    background:white;
    border:1px solid #ddd;
    border-radius:8px;
    margin-top:5px;
    max-height:220px;
    overflow-y:auto;
    display:none;
    z-index:1000;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
}

.category-option{
    padding:12px 14px;
    cursor:pointer;
}

.category-option:hover{
    background:#f3f5fa;
}

.price-input{
    position:relative;
    width:100%;
}

.price-prefix{
    position:absolute;
    left:14px;
    top:50%;
    transform:translateY(-50%);
    color:#555;
    font-weight:500;
    z-index:2;
    pointer-events:none;
}

.price-field{
    padding-left:42px !important;
}

</style>

<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>Tambah Produk</h2>

            <div>

                <a href="{{ route('admin.produk.index') }}"
                   class="btn-cancel">

                    Batal

                </a>

                <button
                    form="productForm"
                    type="submit"
                    class="btn-save">

                    Simpan

                </button>

            </div>

        </div>

    </div>

    <div class="form-body">

        <form
            id="productForm"
            action="{{ route('admin.produk.store') }}"
            method="POST">

            @csrf

            <div class="form-grid">

                <div>

                    <h3 class="section-title">
                        Informasi Produk
                    </h3>

                    <div class="form-group">

                        <label>Kategori</label>

                        <div class="category-search">

                            <input type="text"
                                id="categorySearch"
                                class="form-control"
                                placeholder="Cari kategori..."
                                autocomplete="off"
                                required>

                            <input type="hidden"
                                name="category_id"
                                id="categoryId">

                            <div id="categoryResults"
                                class="category-results">

                                @foreach($categories as $category)

                                    <div class="category-option"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ strtolower($category->nama_kategori) }}">

                                        {{ $category->nama_kategori }}

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Nama Produk</label>

                        <input
                            type="text"
                            name="nama_produk"
                            class="form-control"
                            required>

                    </div>

                    <div class="form-group">

                        <label>
                            SKU
                        </label>

                        <input
                            type="text"
                            id="sku"
                            name="sku"
                            class="form-control"
                            value="{{ old('sku') }}"
                            readonly
                            placeholder="SKU akan dibuat otomatis"
                        >

                        <small style="
                            display:block;
                            margin-top:7px;
                            color:#888;
                            font-size:13px;
                        ">
                            SKU dibuat otomatis berdasarkan kategori produk.
                        </small>

                    </div>

                    <div class="form-group">

                        <label>Barcode</label>

                        <input
                            type="text"
                            name="barcode"
                            class="form-control">

                    </div>

                </div>

                <div>

                    <h3 class="section-title">
                        Detail Stok & Harga
                    </h3>

                    <div class="form-group">

                        <label>Stok Awal</label>

                        <input
                            type="number"
                            name="stok"
                            class="form-control"
                            min="0"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Stok Minimum</label>

                        <input
                            type="number"
                            name="stok_minimum"
                            value="10"
                            class="form-control"
                            min="0"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Satuan</label>

                        <input
                            type="text"
                            name="satuan"
                            class="form-control"
                            placeholder="Contoh: Sak, Kg, Batang"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Harga Beli</label>

                        <div class="price-input">

                            <span class="price-prefix">Rp.</span>

                            <input type="text"
                                id="harga_beli_display"
                                class="form-control price-field"
                                placeholder="0"
                                autocomplete="off"
                                inputmode="numeric"
                                required>

                            <input type="hidden"
                                name="harga_beli"
                                id="harga_beli">

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Harga Jual</label>

                        <div class="price-input">

                            <span class="price-prefix">Rp.</span>

                            <input type="text"
                                id="harga_jual_display"
                                class="form-control price-field"
                                placeholder="0"
                                autocomplete="off"
                                inputmode="numeric"
                                required>

                            <input type="hidden"
                                name="harga_jual"
                                id="harga_jual">

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Status</label>

                        <select
                            name="status"
                            class="form-control"
                            required>

                            <option value="Aktif">
                                Aktif
                            </option>

                            <option value="Nonaktif">
                                Nonaktif
                            </option>

                        </select>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script>

function formatRupiah(value)
{
    let angka = value.replace(/\D/g, '');

    if (angka === '') {
        return '';
    }

    return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}


// ==========================================================
// HARGA
// ==========================================================

const hargaBeliDisplay = document.getElementById('harga_beli_display');
const hargaBeli = document.getElementById('harga_beli');

const hargaJualDisplay = document.getElementById('harga_jual_display');
const hargaJual = document.getElementById('harga_jual');


hargaBeliDisplay.addEventListener('input', function(){

    let angka = this.value.replace(/\D/g, '');

    this.value = formatRupiah(angka);

    hargaBeli.value = angka;

});


hargaJualDisplay.addEventListener('input', function(){

    let angka = this.value.replace(/\D/g, '');

    this.value = formatRupiah(angka);

    hargaJual.value = angka;

});


// ==========================================================
// KATEGORI
// ==========================================================

const categorySearch = document.getElementById('categorySearch');
const categoryId = document.getElementById('categoryId');
const categoryResults = document.getElementById('categoryResults');

const categoryOptions = document.querySelectorAll('.category-option');


// ==========================================================
// SKU
// ==========================================================

const skuInput = document.getElementById('sku');


// ==========================================================
// TAMPILKAN DAFTAR KATEGORI SAAT INPUT DIKLIK
// ==========================================================

categorySearch.addEventListener('focus', function(){

    categoryResults.style.display = 'block';

});


// ==========================================================
// PENCARIAN KATEGORI
// ==========================================================

categorySearch.addEventListener('input', function(){

    const keyword = this.value.toLowerCase().trim();

    let found = false;

    // Karena Admin mengetik ulang kategori,
    // pilihan kategori sebelumnya harus dihapus.
    categoryId.value = '';

    // Kosongkan SKU karena kategori belum dipilih kembali.
    skuInput.value = '';

    categoryOptions.forEach(function(option){

        const name = option.dataset.name;

        if(name.includes(keyword)){

            option.style.display = 'block';

            found = true;

        }else{

            option.style.display = 'none';

        }

    });

    categoryResults.style.display = 'block';

});


// ==========================================================
// PILIH KATEGORI
// ==========================================================

categoryOptions.forEach(function(option){

    option.addEventListener('click', function(){

        // Tampilkan nama kategori pada input
        categorySearch.value = this.textContent.trim();

        // Simpan ID kategori
        categoryId.value = this.dataset.id;

        // Tutup daftar kategori
        categoryResults.style.display = 'none';


        // ==================================================
        // GENERATE / PREVIEW SKU OTOMATIS
        // ==================================================

        const selectedCategoryId = this.dataset.id;

        skuInput.value = 'Membuat SKU...';


        fetch(
            "{{ route('admin.produk.preview-sku') }}?category_id=" +
            encodeURIComponent(selectedCategoryId)
        )
        .then(function(response){

            if(!response.ok){

                throw new Error(
                    'Gagal mengambil SKU.'
                );

            }

            return response.json();

        })
        .then(function(data){

            if(data.success){

                skuInput.value = data.sku;

            }else{

                skuInput.value = '';

                alert(
                    data.message ||
                    'SKU tidak dapat dibuat.'
                );

            }

        })
        .catch(function(error){

            console.error(error);

            skuInput.value = '';

            alert(
                'Terjadi kesalahan saat membuat SKU.'
            );

        });

    });

});


// ==========================================================
// TUTUP HASIL PENCARIAN KATEGORI
// JIKA KLIK DI LUAR AREA KATEGORI
// ==========================================================

document.addEventListener('click', function(event){

    if(!event.target.closest('.category-search')){

        categoryResults.style.display = 'none';

    }

});


// ==========================================================
// VALIDASI FORM SEBELUM SUBMIT
// ==========================================================

document.getElementById('productForm').addEventListener('submit', function(event){

    /*
    |--------------------------------------------------------------------------
    | KATEGORI
    |--------------------------------------------------------------------------
    | Jika Admin belum memilih kategori dari daftar,
    | jangan lanjutkan proses penyimpanan.
    */

    if(!categoryId.value){

        event.preventDefault();

        categorySearch.value = '';

        categorySearch.focus();

        alert(
            'Silakan pilih kategori terlebih dahulu.'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | SKU
    |--------------------------------------------------------------------------
    | SKU harus sudah berhasil dibuat sebelum data dikirim.
    */

    if(!skuInput.value || skuInput.value === 'Membuat SKU...'){

        event.preventDefault();

        alert(
            'SKU belum berhasil dibuat. Silakan pilih kategori kembali.'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | HARGA
    |--------------------------------------------------------------------------
    | Hilangkan titik pemisah ribuan sebelum data dikirim.
    */

    hargaBeli.value =
        hargaBeliDisplay.value.replace(/\./g, '');

    hargaJual.value =
        hargaJualDisplay.value.replace(/\./g, '');

});

</script>

@endsection