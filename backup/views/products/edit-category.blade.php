@extends('layouts.app')

@section('title','Edit Kategori Produk')

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
    font-size:32px;
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

            <h2>Edit Kategori Produk</h2>

            <div>

                <a href="{{ route('kategori-produk.index') }}"
                   class="btn-cancel">

                    Batal

                </a>

                <button form="editCategoryForm"
                        type="submit"
                        class="btn-save">

                    Simpan Perubahan

                </button>

            </div>

        </div>

    </div>

    <div class="form-body">

        <form id="editCategoryForm"
              action="{{ route('kategori-produk.update',$kategori_produk->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>Nama Kategori *</label>

                <input type="text"
                       name="nama_kategori"
                       class="form-control"
                       value="{{ $kategori_produk->nama_kategori }}"
                       required>

            </div>

            <div class="form-group">

                <label>Deskripsi</label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    rows="5">{{ $kategori_produk->deskripsi }}</textarea>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="Aktif"
                        {{ $kategori_produk->status == 'Aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="Nonaktif"
                        {{ $kategori_produk->status == 'Nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>

                </select>

            </div>

        </form>

    </div>

</div>

@endsection