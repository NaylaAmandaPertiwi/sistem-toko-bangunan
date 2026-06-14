@extends('layouts.app')

@section('title','Tambah Stok Masuk')

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

</style>

<div class="page-card">

    <div class="page-header">

        <div class="page-title">

            <h2>
                {{ isset($stockIn)
                    ? 'Edit Stok Masuk'
                    : 'Tambah Stok Masuk' }}
            </h2>

            <div>

                <a href="{{ route('stok-masuk.index') }}"
                   class="btn-cancel">

                    Batal

                </a>

                <button
                    type="submit"
                    form="stockInForm"
                    class="btn-save">

                    Simpan

                </button>

            </div>

        </div>

    </div>

    <div class="form-body">

        <form
            id="stockInForm"
            action="{{
                isset($stockIn)
                ? route('stok-masuk.update',$stockIn->id)
                : route('stok-masuk.store')
            }}"
            method="POST">

            @csrf

            @if(isset($stockIn))
                @method('PUT')
            @endif

            <div class="form-grid">

                <div>

                    <h3 class="section-title">
                        Informasi Transaksi
                    </h3>

                    <div class="form-group">

                        <label>No Transaksi</label>

                        <input
                            type="text"
                            name="nomor_transaksi"
                            class="form-control"
                            value="{{ $stockIn->nomor_transaksi ?? 'SM-'.date('YmdHis') }}"
                            readonly>

                    </div>

                    <div class="form-group">

                        <label>Tanggal Masuk</label>

                        <input
                            type="date"
                            name="tanggal_masuk"
                            class="form-control"
                            value="{{ $stockIn->tanggal_masuk ?? '' }}">

                    </div>

                    <div class="form-group">

                        <label>Supplier</label>

                        <select
                            name="supplier_id"
                            class="form-control">

                            <option value="">
                                Pilih Supplier
                            </option>

                            @foreach($suppliers as $supplier)

                                <option
                                    value="{{ $supplier->id }}"
                                    {{ isset($stockIn) && $stockIn->supplier_id == $supplier->id ? 'selected' : '' }}>

                                    {{ $supplier->nama_supplier }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div>

                    <h3 class="section-title">
                        Detail Barang
                    </h3>

                    <div class="form-group">

                        <label>Produk</label>

                        <select
                            name="product_id"
                            class="form-control">

                            <option value="">
                                Pilih Produk
                            </option>

                            @foreach($products as $product)

                                <option
                                    value="{{ $product->id }}"
                                    {{ isset($stockIn) && $stockIn->product_id == $product->id ? 'selected' : '' }}>

                                    {{ $product->nama_produk }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Jumlah Masuk</label>

                        <input
                            type="number"
                            name="jumlah_masuk"
                            class="form-control"
                            value="{{ $stockIn->jumlah_masuk ?? '' }}">

                    </div>

                    <div class="form-group">

                        <label>Harga Beli</label>

                        <input
                            type="number"
                            name="harga_beli"
                            class="form-control"
                            value="{{ $stockIn->harga_beli ?? '' }}">

                    </div>

                    <div class="form-group">

                        <label>Keterangan</label>

                        <textarea
                            name="keterangan"
                            rows="4"
                            class="form-control">{{ $stockIn->keterangan ?? '' }}</textarea>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection