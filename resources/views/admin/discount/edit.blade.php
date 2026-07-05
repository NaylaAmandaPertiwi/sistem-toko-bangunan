@extends('layouts.admin')

@section('title','Edit Diskon')

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

            <h2>Edit Diskon</h2>

            <div>

                <a
                    href="{{ route('admin.discount.index') }}"
                    class="btn-cancel">

                    Batal

                </a>

                <button
                    form="discountForm"
                    type="submit"
                    class="btn-save">

                    Simpan

                </button>

            </div>

        </div>

    </div>

    <div class="form-body">

        <form
            id="discountForm"
            action="{{ route('admin.discount.update', $diskon) }}"
            method="POST">

            @csrf
            @method('PUT')

            <h3 class="section-title">
                Informasi Diskon
            </h3>

            <div class="form-group">

                <label>Nama Diskon</label>

                <input
                    type="text"
                    name="nama_diskon"
                    value="{{ $diskon->nama_diskon }}"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Minimal Belanja (Rp)</label>

                <input
                    type="number"
                    name="minimal_belanja"
                    value="{{ $diskon->minimal_belanja }}"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Persentase Diskon (%)</label>

                <input
                    type="number"
                    name="persentase_diskon"
                    value="{{ $diskon->persentase_diskon }}"
                    class="form-control">

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option
                        value="Aktif"
                        {{ $diskon->status == 'Aktif' ? 'selected' : '' }}>

                        Aktif

                    </option>

                    <option
                        value="Nonaktif"
                        {{ $diskon->status == 'Nonaktif' ? 'selected' : '' }}>

                        Nonaktif

                    </option>

                </select>

            </div>

        </form>

    </div>

</div>

@endsection