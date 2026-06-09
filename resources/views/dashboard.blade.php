@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')



    <!-- HEADER -->
    <div class="header">

        <h2>Dashboard Owner</h2>

    </div>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Jumlah Transaksi</h3>
            <p>{{ $data['total_transaksi'] }}</p>
        </div>

        <div class="card">
            <h3>Stok Menipis</h3>
            <p>{{ $data['stok_menipis'] }}</p>
        </div>

        <div class="card">
            <h3>Total Penjualan</h3>
            <p>Rp {{ number_format($data['total_penjualan'],0,',','.') }}</p>
        </div>

        <div class="card">
            <h3>Diskon Aktif</h3>
            <p>{{ $data['diskon_aktif'] }}</p>
        </div>

    </div>

    <!-- ROW -->
    <div class="row">

        <div class="box">
            <h3>Grafik Penjualan</h3>
            <br>
            <p>Grafik penjualan nanti bisa menggunakan Chart.js</p>
        </div>

        <div class="box">
            <h3>Peringatan Stok</h3>
            <br>
            <p>Beberapa barang hampir habis.</p>
        </div>

    </div>

    <!-- TABLE -->
    <div class="box">

        <h3>Transaksi Terakhir</h3>

        <table>

            <tr>
                <th>ID</th>
                <th>Waktu</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>#TRX-94821</td>
                <td>14:23</td>
                <td>Budi</td>
                <td>Rp 156.000</td>
                <td>
                    <span class="status">
                        SUKSES
                    </span>
                </td>
            </tr>

        </table>

    </div>



@endsection