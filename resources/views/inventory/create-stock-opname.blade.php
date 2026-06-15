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
            method="POST">

            @csrf

            <h3 class="section-title">

                Informasi Opname

            </h3>

            <div class="form-group">

                <label>No Opname</label>

                <input
                    type="text"
                    name="nomor_opname"
                    class="form-control"
                    value="SO-{{ date('YmdHis') }}"
                    readonly>

            </div>

            <div class="form-group">

                <label>Tanggal Opname</label>

                <input
                    type="date"
                    name="tanggal_opname"
                    class="form-control"
                    value="{{ date('Y-m-d') }}">

            </div>

            <div class="form-group">

                <label>Keterangan</label>

                <textarea
                    name="keterangan"
                    rows="3"
                    class="form-control"></textarea>

            </div>

            <h3 class="section-title">

                Detail Produk

            </h3>

            <div class="table-wrapper">

                <table class="stock-table">

                    <thead>

                        <tr>

                            <th>Produk</th>

                            <th>SKU</th>

                            <th>Stok Sistem</th>

                            <th>Stok Fisik</th>

                            <th>Selisih</th>

                        </tr>

                    </thead>

                    <tbody>

                    @foreach($products as $product)

                    <tr>

                        <td>

                            {{ $product->nama_produk }}

                            <input
                                type="hidden"
                                name="products[{{ $loop->index }}][product_id]"
                                value="{{ $product->id }}">

                        </td>

                        <td>

                            {{ $product->sku }}

                        </td>

                        <td>

                            {{ $product->stok }}

                            <input
                                type="hidden"
                                class="stok-sistem"
                                name="products[{{ $loop->index }}][stok_sistem]"
                                value="{{ $product->stok }}">

                        </td>

                        <td>

                            <input
                                type="number"
                                class="form-control stok-fisik"
                                name="products[{{ $loop->index }}][stok_fisik]"
                                value="{{ $product->stok }}">

                        </td>

                        <td>

                            <span class="selisih">

                                0

                            </span>

                        </td>

                    </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script>

document
.querySelectorAll('.stok-fisik')
.forEach(function(input){

    input.addEventListener('keyup', hitungSelisih);
    input.addEventListener('change', hitungSelisih);

});

function hitungSelisih()
{
    document
    .querySelectorAll('tbody tr')
    .forEach(function(row){

        let stokSistem =
            parseInt(
                row.querySelector('.stok-sistem').value
            ) || 0;

        let stokFisik =
            parseInt(
                row.querySelector('.stok-fisik').value
            ) || 0;

        let selisih =
            stokFisik - stokSistem;

        row.querySelector('.selisih')
            .innerText = selisih;
    });
}

</script>

@endsection