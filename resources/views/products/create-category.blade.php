@extends('layouts.app')

@section('title','Tambah Kategori Produk')

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

.btn-save{
    background:#57c13b;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:8px;
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

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
}

</style>

<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>Tambah Kategori Produk</h2>

            <div>

                <a href="{{ route('kategori-produk.index') }}"
                   class="btn-cancel">

                    Batal

                </a>

                <button form="categoryForm"
                        type="submit"
                        class="btn-save">

                    Simpan

                </button>

            </div>

        </div>

    </div>

    <div class="form-body">

        <form id="categoryForm"
              action="{{ route('kategori-produk.store') }}"
              method="POST">

            @csrf

            <div class="form-group">

                <label>Nama Kategori *</label>

                <input type="text"
                       name="nama_kategori"
                       class="form-control"
                       required>

            </div>

            <div class="form-group">

                <label>Deskripsi</label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    rows="5"></textarea>

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

        </form>

    </div>

</div>

@endsection