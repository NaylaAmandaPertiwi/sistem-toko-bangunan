@extends('layouts.admin')

@section('title','Edit Produk')

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

/* ============================= */
/* SEARCHABLE CATEGORY */
/* ============================= */

.category-select{
    position:relative;
}

.category-dropdown{
    display:none;
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
    z-index:1000;
    box-shadow:0 4px 12px rgba(0,0,0,.12);
}

.category-option{
    padding:12px 15px;
    cursor:pointer;
    font-size:15px;
}

.category-option:hover{
    background:#f1f5f9;
}

.category-option.active{
    background:#1684e0;
    color:white;
}


/* ============================= */
/* HARGA */
/* ============================= */

#hargaBeliDisplay,
#hargaJualDisplay{
    font-family:inherit;
}

</style>

<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>Edit Produk</h2>

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
            action="{{ route('admin.produk.update',$produk->id) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="form-grid">

                <div>

                    <h3 class="section-title">
                        Informasi Produk
                    </h3>

                    <div class="form-group">

                        <label>Kategori</label>

                        <div class="category-select">

                            <input type="text"
                                id="categorySearch"
                                class="form-control"
                                placeholder="Cari kategori..."
                                value="{{ $produk->category->nama_kategori ?? '' }}"
                                autocomplete="off"
                                required>

                            <input type="hidden"
                                name="category_id"
                                id="categoryId"
                                value="{{ $produk->category_id }}">

                            <div class="category-dropdown"
                                id="categoryDropdown">

                                @foreach($categories as $category)

                                    <div class="category-option"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->nama_kategori }}">

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
                            value="{{ $produk->nama_produk }}"
                            class="form-control">

                    </div>

                    <div class="form-group">

                        <label>SKU</label>

                        <input
                            type="text"
                            name="sku"
                            value="{{ $produk->sku }}"
                            class="form-control">
                    </div>

                    <div class="form-group">

                        <label>Barcode</label>

                        <input
                            type="text"
                            name="barcode"
                            value="{{ $produk->barcode }}"
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
                            value="{{ $produk->stok }}"
                            class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Stok Minimum</label>

                        <input
                            type="number"
                            name="stok_minimum"
                            value="{{ $produk->stok_minimum ?? 10 }}"
                            class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Satuan</label>

                        <input
                            type="text"
                            name="satuan"
                            value="{{ $produk->satuan }}"
                            class="form-control"
                            placeholder="Contoh: Sak, Kg, Batang">

                    </div>

                    <div class="form-group">

                        <label>Harga Beli</label>

                        <input type="text"
                            id="hargaBeliDisplay"
                            class="form-control"
                            value="Rp. {{ number_format($produk->harga_beli, 0, ',', '.') }}"
                            inputmode="numeric"
                            autocomplete="off"
                            required>

                        <input type="hidden"
                            name="harga_beli"
                            id="hargaBeli"
                            value="{{ (int) $produk->harga_beli }}">

                    </div>

                    <div class="form-group">

                        <label>Harga Jual</label>

                        <input type="text"
                            id="hargaJualDisplay"
                            class="form-control"
                            value="Rp. {{ number_format($produk->harga_jual, 0, ',', '.') }}"
                            inputmode="numeric"
                            autocomplete="off"
                            required>

                        <input type="hidden"
                            name="harga_jual"
                            id="hargaJual"
                            value="{{ (int) $produk->harga_jual }}">

                    </div>

                    <div class="form-group">

                        <label>Status</label>

                        <select
                            name="status"
                            class="form-control">

                            <option value="Aktif"
                                {{ $produk->status == 'Aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="Nonaktif"
                                {{ $produk->status == 'Nonaktif' ? 'selected' : '' }}>
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

document.addEventListener('DOMContentLoaded', function () {

    /* =====================================
       SEARCHABLE KATEGORI
    ===================================== */

    const categorySearch =
        document.getElementById('categorySearch');

    const categoryId =
        document.getElementById('categoryId');

    const categoryDropdown =
        document.getElementById('categoryDropdown');

    const categoryOptions =
        document.querySelectorAll('.category-option');


    // Tampilkan dropdown ketika input diklik
    categorySearch.addEventListener('focus', function () {

        categoryDropdown.style.display = 'block';

        filterCategories();

    });


    // Live search kategori
    categorySearch.addEventListener('input', function () {

        categoryId.value = '';

        categoryDropdown.style.display = 'block';

        filterCategories();

    });


    function filterCategories() {

        const keyword =
            categorySearch.value.toLowerCase().trim();

        let found = false;

        categoryOptions.forEach(function (option) {

            const name =
                option.dataset.name.toLowerCase();

            if (name.includes(keyword)) {

                option.style.display = 'block';

                found = true;

            } else {

                option.style.display = 'none';

            }

        });

        categoryDropdown.style.display =
            found ? 'block' : 'none';

    }


    // Pilih kategori
    categoryOptions.forEach(function (option) {

        option.addEventListener('click', function () {

            categorySearch.value =
                this.dataset.name;

            categoryId.value =
                this.dataset.id;

            categoryDropdown.style.display =
                'none';

        });

    });


    // Klik di luar dropdown
    document.addEventListener('click', function (event) {

        if (!event.target.closest('.category-select')) {

            categoryDropdown.style.display =
                'none';

        }

    });


    /* =====================================
       FORMAT HARGA
    ===================================== */

    function setupPriceInput(displayId, hiddenId) {

        const display =
            document.getElementById(displayId);

        const hidden =
            document.getElementById(hiddenId);


        display.addEventListener('input', function () {

            // Ambil hanya angka
            let numbers =
                this.value.replace(/\D/g, '');


            // Kalau kosong
            if (numbers === '') {

                this.value = '';

                hidden.value = '';

                return;

            }


            // Simpan angka murni ke hidden input
            hidden.value = numbers;


            // Format menjadi Rp. 25.000
            this.value =
                'Rp. ' +
                Number(numbers).toLocaleString('id-ID');

        });


        // Saat halaman pertama kali dibuka
        if (hidden.value !== '') {

            display.value =
                'Rp. ' +
                Number(hidden.value)
                    .toLocaleString('id-ID');

        }

    }


    setupPriceInput(
        'hargaBeliDisplay',
        'hargaBeli'
    );


    setupPriceInput(
        'hargaJualDisplay',
        'hargaJual'
    );


    /* =====================================
       VALIDASI FORM
    ===================================== */

    const form =
        document.querySelector('form');

    if (form) {

        form.addEventListener('submit', function (event) {

            // Pastikan kategori sudah dipilih
            if (!categoryId.value) {

                event.preventDefault();

                alert('Silakan pilih kategori produk.');

                categorySearch.focus();

                return;

            }

            // Pastikan harga beli berupa angka
            if (
                !/^\d+$/.test(
                    document.getElementById('hargaBeli').value
                )
            ) {

                event.preventDefault();

                alert('Harga beli hanya boleh berisi angka.');

                return;

            }

            // Pastikan harga jual berupa angka
            if (
                !/^\d+$/.test(
                    document.getElementById('hargaJual').value
                )
            ) {

                event.preventDefault();

                alert('Harga jual hanya boleh berisi angka.');

                return;

            }

        });

    }

});

</script>

@endsection