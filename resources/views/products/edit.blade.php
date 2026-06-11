@extends('layouts.app')

@section('title','Edit Produk')

@section('content')

<div class="page-card">

```
<div class="page-header">

    <h2>Edit Produk</h2>

    <div>

        <a href="{{ route('produk.index') }}">
            Batal
        </a>

        <button
            form="productForm"
            type="submit">

            Simpan Perubahan

        </button>

    </div>

</div>

<form
    id="productForm"
    action="{{ route('produk.update',$produk->id) }}"
    method="POST">

    @csrf
    @method('PUT')

    <label>Kategori</label>

    <select name="category_id">

        @foreach($categories as $category)

            <option
                value="{{ $category->id }}"
                {{ $produk->category_id == $category->id ? 'selected' : '' }}>

                {{ $category->nama_kategori }}

            </option>

        @endforeach

    </select>

    <label>Nama Produk</label>

    <input
        type="text"
        name="nama_produk"
        value="{{ $produk->nama_produk }}">

    <label>SKU</label>

    <input
        type="text"
        name="sku"
        value="{{ $produk->sku }}">

    <label>Barcode</label>

    <input
        type="text"
        name="barcode"
        value="{{ $produk->barcode }}">

    <label>Stok</label>

    <input
        type="number"
        name="stok"
        value="{{ $produk->stok }}">

    <label>Satuan</label>

    <input
        type="text"
        name="satuan"
        value="{{ $produk->satuan }}">

    <label>Harga Beli</label>

    <input
        type="number"
        name="harga_beli"
        value="{{ $produk->harga_beli }}">

    <label>Harga Jual</label>

    <input
        type="number"
        name="harga_jual"
        value="{{ $produk->harga_jual }}">

    <label>Status</label>

    <select name="status">

        <option value="Aktif"
            {{ $produk->status == 'Aktif' ? 'selected' : '' }}>
            Aktif
        </option>

        <option value="Nonaktif"
            {{ $produk->status == 'Nonaktif' ? 'selected' : '' }}>
            Nonaktif
        </option>

    </select>

</form>
```

</div>

@endsection
