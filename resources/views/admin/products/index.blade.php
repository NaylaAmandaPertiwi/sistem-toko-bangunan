@extends('layouts.admin')

@section('title', 'Produk')

@section('content')

<style>

/* HEADER */
.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* TOP HEADER */
.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

/* FILTER */
.filter-section{
    padding:25px;
    display:flex;
    justify-content:space-between;
    gap:15px;
    flex-wrap:wrap;
}

.left-filter{
    display:flex;
    gap:15px;
}

.filter-box{
    background:white;
    border:1px solid #ddd;
    border-radius:10px;
    padding:12px 16px;
    min-width:200px;
    cursor:pointer;
}

.search-box{
    flex:1;
}

.search-box input{
    width:100%;
    padding:12px 16px;
    border:1px solid #ddd;
    border-radius:10px;
}

/* BUTTON */
.add-btn{
    background:#4CAF50;
    color:white;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
    text-decoration:none;
}

.add-btn:hover{
    background:#43a047;
    text-decoration:none;
    color:white;
}

/* TABLE */
.table-section{
    padding:25px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:12px;
    overflow:hidden;
}

table th{
    background:#f3f5fa;
    padding:16px;
    text-align:left;
}

table td{
    padding:16px;
    border-bottom:1px solid #eee;
}

.no-data{
    text-align:center;
    padding:40px;
    color:#999;
}

.table-wrapper{
    overflow-x:auto;
}

table{
    min-width:1200px;
}

thead th{
    white-space:nowrap;
}

th i{
    font-size:12px;
    margin-left:5px;
    color:#999;
}

.table-footer{
    margin-top:18px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    flex-wrap:wrap;

    gap:15px;
}

.footer-left,
.footer-right{
    display:flex;
    align-items:center;
    gap:14px;
}

.footer-left select{
    padding:8px 12px;
    border:1px solid #ddd;
    border-radius:8px;
}

.footer-right button{
    border:none;
    background:none;
    cursor:pointer;
    color:#666;
}

.footer-right input{
    width:60px;
    padding:8px;
    border:1px solid #ddd;
    border-radius:8px;
    text-align:center;
}

.page-active{
    color:#1684e0;
    font-weight:600;
}

.delete-btn{
    border:none;
    background:none;
    cursor:pointer;
    font-size:18px;
    color:#999;
}

.status-active{
    background:#d1fae5;
    color:#065f46;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status-inactive{
    background:#fee2e2;
    color:#991b1b;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.col-produk,
.col-sku{
    white-space: nowrap;
}



</style>




    <div class="page-header">

        <!-- HEADER -->
        <div class="top-header">

            Produk

        </div>

        <!-- FILTER -->
        <div class="filter-section">

            <form
                method="GET"
                action="{{ route('admin.produk.index') }}"
                style="display:flex;gap:15px;width:100%;">

                <div class="left-filter">

                    <select
                        name="category"
                        class="filter-box"
                        onchange="this.form.submit()">

                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>

                                {{ $category->nama_kategori }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="search-box">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Produk"
                        onchange="this.form.submit()">

                </div>

                <button
                    type="submit"
                    class="add-btn">

                    Cari

                </button>

                <a href="{{ route('admin.produk.create') }}"
                class="add-btn">

                    Tambah Produk

                </a>

            </form>

        </div>

        <!-- TABLE -->
        <div class="table-section">

            <form id="bulkDeleteForm"
                action="{{ route('admin.produk.bulkDelete') }}"
                method="POST">

                @csrf
                @method('DELETE')

                <input type="hidden"
                    name="ids"
                    id="selectedIds">

            </form>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th width="40">
                                <input type="checkbox"
                                    id="checkAll">
                            </th>

                            <th width="250">
                                Nama Produk
                            </th>

                            <th>
                                Kategori
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th width="180">
                                SKU
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Barcode
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th width="150">
                                Qty Stok
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Stok Minimum
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Satuan
                                <i class="fa-solid fa-sort"></i>
                            </th>

                            <th>
                                Harga Beli
                            </th>

                            <th>
                                Harga Jual
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($products as $product)

                        <tr>

                            <td>

                                <input type="checkbox"
                                    class="product-checkbox"
                                    value="{{ $product->id }}">

                            </td>

                            <td class="col-produk">
                                {{ $product->nama_produk }}
                            </td>

                            <td>
                                {{ $product->category->nama_kategori ?? '-' }}
                            </td>

                            <td class="col-sku">
                                {{ $product->sku }}
                            </td>

                            <td>
                                {{ $product->barcode }}
                            </td>

                            <td>
                                {{ $product->stok }}
                            </td>

                            <td>
                                {{ $product->stok_minimum }}
                            </td>

                            <td>
                                {{ $product->satuan }}
                            </td>

                            <td>
                                Rp {{ number_format($product->harga_beli,0,',','.') }}
                            </td>

                            <td>
                                Rp {{ number_format($product->harga_jual,0,',','.') }}
                            </td>

                            <td>

                                @if($product->status == 'Aktif')

                                    <span class="status-active">
                                        Aktif
                                    </span>

                                @else

                                    <span class="status-inactive">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.produk.edit',$product->id) }}"
                                class="edit-btn">

                                    <i class="fa-solid fa-pen"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="12"
                                class="no-data">

                                Belum ada produk

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- FOOTER TABLE -->
            <div class="table-footer">

                <div class="footer-left">

                    <button
                        type="button"
                        class="delete-btn"
                        onclick="bulkDelete()">

                        <i class="fa-regular fa-trash-can"></i>

                    </button>

                    <select>

                        <option>10/page</option>
                        <option>25/page</option>
                        <option>50/page</option>

                    </select>

                    <span>Total {{ $products->count() }}</span>

                </div>

                <div class="footer-right">

                    <button>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <span class="page-active">1</span>

                    <button>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    <span>Go to</span>

                    <input type="number"
                        value="1">

                </div>

            </div>

        </div>

    </div>

    <script>

    document.getElementById('checkAll')
    .addEventListener('change', function(){

        document
        .querySelectorAll('.product-checkbox')
        .forEach(item => {

            item.checked = this.checked;

        });

    });

    function bulkDelete()
    {
        let ids = [];

        document
        .querySelectorAll('.product-checkbox:checked')
        .forEach(item => {

            ids.push(item.value);

        });

        if(ids.length === 0)
        {
            alert('Pilih produk terlebih dahulu');
            return;
        }

        if(confirm('Hapus produk yang dipilih?'))
        {
            document.getElementById('selectedIds').value =
                ids.join(',');

            document
                .getElementById('bulkDeleteForm')
                .submit();
        }
    }

    </script>


@endsection