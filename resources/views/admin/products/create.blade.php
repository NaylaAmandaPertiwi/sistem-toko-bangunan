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

</style>

<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>Tambah Produk</h2>

            <div>

                <a href="{{ route('produk.index') }}"
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
            action="{{ route('produk.store') }}"
            method="POST">

            @csrf

            <div class="form-grid">

                <div>

                    <h3 class="section-title">
                        Informasi Produk
                    </h3>

                    <div class="form-group">

                        <label>Kategori</label>

                        <select
                            name="category_id"
                            class="form-control">

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}">

                                    {{ $category->nama_kategori }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Nama Produk</label>

                        <input
                            type="text"
                            name="nama_produk"
                            class="form-control">

                    </div>

                    <div class="form-group">

                        <label>SKU</label>

                        <input
                            type="text"
                            name="sku"
                            class="form-control">

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
                            class="form-control"
                            placeholder="Contoh: Sak, Kg, Batang">

                    </div>

                    <div class="form-group">

                        <label>Harga Beli</label>

                        <input
                            type="number"
                            name="harga_beli"
                            class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Harga Jual</label>

                        <input
                            type="number"
                            name="harga_jual"
                            class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Status</label>

                        <select
                            name="status"
                            class="form-control">

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