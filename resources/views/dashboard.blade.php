@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="header">
    <h2>Dashboard Owner</h2>
</div>

<!-- CARD STATISTIK -->
<div class="cards">

    <div class="card">
        <h3>Total Produk</h3>
        <p>{{ $data['total_produk'] ?? 250 }}</p>
    </div>

    <div class="card">
        <h3>Total Supplier</h3>
        <p>{{ $data['total_supplier'] ?? 15 }}</p>
    </div>

    <div class="card">
        <h3>Transaksi Hari Ini</h3>
        <p>{{ $data['total_transaksi'] ?? 32 }}</p>
    </div>

    <div class="card">
        <h3>Pendapatan Hari Ini</h3>
        <p>Rp {{ number_format($data['total_penjualan'] ?? 7500000,0,',','.') }}</p>
    </div>

</div>

<!-- GRAFIK -->
<div class="box" style="margin-bottom:25px;">

    <h3>Grafik Penjualan 7 Hari Terakhir</h3>

    <canvas id="salesChart" height="90"></canvas>

</div>

<!-- PERINGATAN STOK + PRODUK TERLARIS -->
<div class="row">

    <div class="box">

        <h3>Peringatan Stok</h3>

        <table>
            <tr>
                <th>Produk</th>
                <th>Stok</th>
            </tr>

            <tr>
                <td>Semen Padang</td>
                <td>5</td>
            </tr>

            <tr>
                <td>Cat Avian</td>
                <td>3</td>
            </tr>

            <tr>
                <td>Paku 7 cm</td>
                <td>4</td>
            </tr>

        </table>

    </div>

    <div class="box">

        <h3>Produk Terlaris</h3>

        <table>

            <tr>
                <th>Produk</th>
                <th>Terjual</th>
            </tr>

            <tr>
                <td>Semen Padang</td>
                <td>120</td>
            </tr>

            <tr>
                <td>Cat Avian</td>
                <td>95</td>
            </tr>

            <tr>
                <td>Besi Beton</td>
                <td>70</td>
            </tr>

        </table>

    </div>

</div>

<!-- TRANSAKSI TERAKHIR -->
<div class="box" style="margin-bottom:25px;">

    <h3>Transaksi Terakhir</h3>

    <table>

        <tr>
            <th>Invoice</th>
            <th>Kasir</th>
            <th>Total</th>
            <th>Status</th>
        </tr>

        <tr>
            <td>INV001</td>
            <td>Budi</td>
            <td>Rp 350.000</td>
            <td>
                <span class="status">
                    SUKSES
                </span>
            </td>
        </tr>

        <tr>
            <td>INV002</td>
            <td>Sinta</td>
            <td>Rp 780.000</td>
            <td>
                <span class="status">
                    SUKSES
                </span>
            </td>
        </tr>

    </table>

</div>

<!-- DISKON AKTIF -->
<div class="box">

    <h3>Diskon Aktif</h3>

    <table>

        <tr>
            <th>Nama Diskon</th>
            <th>Status</th>
        </tr>

        <tr>
            <td>Diskon Cat Avian 10%</td>
            <td>
                <span class="status">
                    AKTIF
                </span>
            </td>
        </tr>

        <tr>
            <td>Diskon Semen Padang 5%</td>
            <td>
                <span class="status">
                    AKTIF
                </span>
            </td>
        </tr>

    </table>

</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx =
document.getElementById('salesChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: [
            'Sen',
            'Sel',
            'Rab',
            'Kam',
            'Jum',
            'Sab',
            'Min'
        ],

        datasets: [{

            label: 'Penjualan',

            data: [
                1200000,
                950000,
                1700000,
                2300000,
                1800000,
                2600000,
                2200000
            ],

            borderColor: '#355cc9',

            tension: 0.4

        }]
    },

    options: {

        responsive: true,

        plugins: {

            legend: {
                display: false
            }

        }

    }

});

</script>

@endsection