@extends('layouts.app')

@section('title','Edit Supplier')

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
    gap:40px;
}

.section-title{
    color:#57c13b;
    font-size:30px;
    margin-bottom:20px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
}

textarea.form-control{
    resize:none;
    height:100px;
}

.photo-box{
    border:1px solid #ddd;
    border-radius:8px;
    padding:20px;
}

</style>

<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>Edit Supplier</h2>

            <div>

                <a href="{{ route('supplier.index') }}"
                   class="btn-cancel">

                    Batal

                </a>

                <button form="supplierForm"
                        type="submit"
                        class="btn-save">

                    Simpan Perubahan

                </button>

            </div>

        </div>

    </div>

    <div class="form-body">

        <form id="supplierForm"
            action="{{ route('supplier.update',$supplier->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-grid">

                <!-- KIRI -->

                <div>

                    <h3 class="section-title">
                        Rincian Supplier
                    </h3>

                    <div class="form-group">

                        <label>Nama Supplier *</label>

                        <input type="text"
                            name="nama_supplier"
                            class="form-control"
                            value="{{ old('nama_supplier',$supplier->nama_supplier) }}"
                            required>

                    </div>

                    <div class="form-group">

                        <label>Personal Yang Dihubungi</label>

                        <input type="text"
                            name="kontak_person"
                            class="form-control"
                            value="{{ old('kontak_person',$supplier->kontak_person) }}">

                    </div>

                    <div class="form-group">

                        <label>Email</label>

                        <input type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email',$supplier->email) }}">

                    </div>

                    <div class="form-group">

                        <label>Telepon</label>

                        <input type="text"
                            name="telepon"
                            class="form-control"
                            value="{{ old('telepon',$supplier->telepon) }}">

                    </div>

                    <div class="form-group">

                        <label>Catatan</label>

                        <textarea
                            name="catatan"
                            class="form-control">{{ old('catatan',$supplier->catatan) }}</textarea>

                    </div>

                </div>

                <!-- KANAN -->

                <div>

                    <h3 class="section-title">
                        Alamat
                    </h3>

                    <div class="photo-box">

                        <label>Foto Supplier</label>

                        @if($supplier->foto)

                            <div style="margin-top:10px">

                                <img src="{{ asset('storage/'.$supplier->foto) }}"
                                    width="120"
                                    style="border-radius:10px">

                            </div>

                        @endif

                    </div>

                    <br>

                    <div class="form-group">

                        <label>Negara</label>

                        <input type="text"
                               name="negara"
                               value="{{ old('negara',$supplier->negara) }}"
                               class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Provinsi</label>

                        <input type="text"
                               value="{{ old('provinsi',$supplier->provinsi) }}"
                               class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Kota</label>

                        <input type="text"
                               value="{{ old('kota',$supplier->kota) }}"
                               class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Kode Pos</label>

                        <input type="text"
                               value="{{ old('kode_pos',$supplier->kode_pos) }}"
                               class="form-control">

                    </div>

                    <div class="form-group">

                        <label>Alamat</label>

                        <textarea
                            name="alamat"
                            class="form-control">{{ old('alamat',$supplier->alamat) }}</textarea>
                        
                        <div class="form-group">

                            <label>Status</label>

                            <select name="status"
                                    class="form-control">

                                <option value="Aktif"
                                    {{ $supplier->status == 'Aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="Nonaktif"
                                    {{ $supplier->status == 'Nonaktif' ? 'selected' : '' }}>
                                    Nonaktif
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection