@extends('layouts.app')

@section('title', 'Tambah Stok Keluar')

@section('content')

<div class="card">

    <h2>Tambah Stok Keluar</h2>

    <form>

        <div>
            <label>Nomor Transaksi</label>
            <input type="text">
        </div>

        <div>
            <label>Tanggal Keluar</label>
            <input type="date">
        </div>

        <div>
            <label>Barang</label>
            <select>
                <option>Pilih Barang</option>
            </select>
        </div>

        <div>
            <label>Jumlah Keluar</label>
            <input type="number">
        </div>

        <div>
            <label>Harga Jual</label>
            <input type="number">
        </div>

        <div>
            <label>Tujuan</label>
            <select>
                <option>Penjualan</option>
                <option>Retur Supplier</option>
                <option>Barang Rusak</option>
                <option>Pemakaian Internal</option>
            </select>
        </div>

        <div>
            <label>Petugas</label>
            
            <select name="petugas">

                <option>Pilih Petugas</option>

                <option>Admin</option>

                <option>Kasir 1</option>

                <option>Kasir 2</option>

            </select>
        </div>

        <button type="submit">
            Simpan
        </button>

    </form>

</div>

@endsection