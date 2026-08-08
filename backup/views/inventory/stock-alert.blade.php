@extends('layouts.app')

@section('title', 'Peringatan Stok')

@section('content')

<style>

.page-card{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
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
}

.filter-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.stock-info h2{
    margin:0;
}

.stock-info span{
    color:#999;
}

.filter-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.search-box{
    width:250px;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.filter-box{
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
}

.stock-table{
    width:100%;
    border-collapse:collapse;
}

.stock-table th{
    background:#f3f5fa;
    padding:14px;
    text-align:left;
}

.stock-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.badge-danger{
    background:#f8d7da;
    color:#721c24;
    padding:6px 12px;
    border-radius:20px;
}

.badge-warning{
    background:#fff3cd;
    color:#856404;
    padding:6px 12px;
    border-radius:20px;
}

.btn-restock{
    background:#1684e0;
    color:white;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
}

</style>

<div class="page-card">

    <div class="top-header">
        Inventory
    </div>

    <div class="filter-section">

        <div class="filter-top">

            <div class="stock-info">

                <h2>Peringatan Stok</h2>

                <span>
                    {{ $products->count() }}
                    Produk Perlu Dipantau
                </span>

            </div>

        </div>

        <div class="filter-bottom">

            <form method="GET">

                <select
                    name="status"
                    class="filter-box"
                    onchange="this.form.submit()">

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="menipis"
                        {{ request('status') == 'menipis' ? 'selected' : '' }}>
                        Hampir Habis
                    </option>

                    <option
                        value="habis"
                        {{ request('status') == 'habis' ? 'selected' : '' }}>
                        Stok Habis
                    </option>

                </select>

            </form>

            <form method="GET">

                <input
                    type="text"
                    name="search"
                    class="search-box"
                    placeholder="Cari Produk"
                    value="{{ request('search') }}"
                    onchange="this.form.submit()">

            </form>

        </div>

    </div>

    <div style="padding:25px;">

        <table class="stock-table">

            <thead>

                <tr>

                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Stok Saat Ini</th>
                    <th>Stok Minimum</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach($products as $product)

                    @if($product->stok <= $product->stok_minimum)

                        <tr>

                            <td>
                                {{ $product->nama_produk }}
                            </td>

                            <td>
                                {{ $product->sku }}
                            </td>

                            <td>
                                {{ $product->stok }}
                            </td>

                            <td>
                                {{ $product->stok_minimum }}
                            </td>

                            <td>

                                @if($product->stok == 0)

                                    <span class="badge-danger">
                                        Stok Habis
                                    </span>

                                @else

                                    <span class="badge-warning">
                                        Hampir Habis
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a
                                    href="{{ route('stok-masuk.create') }}"
                                    class="btn-restock">

                                    Restock

                                </a>

                            </td>

                        </tr>

                    @endif

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection