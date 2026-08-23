@extends('layouts.admin')

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

.form-error {
    margin-top: 7px;
    color: #dc2626;
    font-size: 13px;
}

</style>

<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>Tambah Kategori Produk</h2>

            <div>

                <a href="{{ route('admin.kategori-produk.index') }}"
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
              action="{{ route('admin.kategori-produk.store') }}"
              method="POST">

            @csrf

            <div class="form-group">

                <label for="nama_kategori">
                    Nama Kategori
                </label>

                <input
                    type="text"
                    name="nama_kategori"
                    id="nama_kategori"
                    class="form-control"
                    value="{{ old('nama_kategori') }}"
                    required
                >

                @error('nama_kategori')

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>

            <div class="form-group">

                <label>Deskripsi</label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    rows="5">{{ old('deskripsi') }}</textarea>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option
                        value="Aktif"
                        {{ old('status', 'Aktif') === 'Aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option
                        value="Nonaktif"
                        {{ old('status') === 'Nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>

                </select>

            </div>

        </form>

    </div>

</div>

@endsection