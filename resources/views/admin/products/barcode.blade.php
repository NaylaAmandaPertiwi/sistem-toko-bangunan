@extends('layouts.admin')

@section('title', 'Barcode')

@section('content')

<style>

.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

.filter-section{
    padding:25px;

    display:flex;
    gap:15px;

    flex-wrap:wrap;
}

.filter-box{
    min-width:220px;

    padding:12px 15px;

    border:1px solid #ddd;

    border-radius:10px;
}

.search-box{
    flex:1;
}

.search-box input{
    width:100%;

    padding:12px 15px;

    border:1px solid #ddd;

    border-radius:10px;
}

.print-all-btn{

    background:#28a745;

    color:white;

    border:none;

    padding:12px 18px;

    border-radius:10px;

    cursor:pointer;
}

.table-section{
    padding:25px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f3f5fa;

    padding:15px;
}

table td{
    padding:15px;

    border-bottom:1px solid #eee;
}

.no-data{
    text-align:center;

    padding:40px;

    color:#999;
}

.print-btn{

    background:#1684e0;

    color:white;

    border:none;

    padding:8px 14px;

    border-radius:8px;

    cursor:pointer;
}

</style>

<div class="page-header">

    <div class="top-header">

        Barcode Produk

    </div>

    <div class="filter-section">

        <select class="filter-box">

            <option>
                Semua Kategori
            </option>

        </select>

        <div class="search-box">

            <input type="text"
                   placeholder="Cari Produk atau Barcode">

        </div>

        <button class="print-all-btn">

            <i class="fa-solid fa-print"></i>
            Cetak Semua

        </button>

    </div>

    <div class="table-section">

        <table>

            <thead>

                <tr>

                    <th>Produk</th>

                    <th>SKU</th>

                    <th>Barcode</th>

                    <th>Preview</th>

                    <th>Cetak</th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                <tr>

                    <td>{{ $product->nama_produk }}</td>

                    <td>{{ $product->sku }}</td>

                    <td>{{ $product->barcode }}</td>

                    <td>

                        ||||| |||| |||||<br>

                        {{ $product->barcode }}

                    </td>

                    <td>

                        <button class="print-btn">

                            <i class="fa-solid fa-print"></i>

                        </button>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"
                        class="no-data">

                        Belum ada barcode produk

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection