@extends('layouts.kasir')

@section('styles')

<style>

.page-title{

    font-size:40px;

    font-weight:700;

    margin-bottom:30px;

}

.card-retur{

    background:#fff;

    border-radius:18px;

    padding:25px;

    box-shadow:0 10px 30px rgba(0,0,0,.06);

    margin-bottom:25px;

}

.card-title{

    font-size:20px;

    font-weight:700;

    margin-bottom:20px;

}

.form-control{

    height:48px;

    border-radius:12px;

}

.form-select{

    height:48px;

    border-radius:12px;

}

textarea{

    border-radius:12px !important;

}

.btn-primary{

    border-radius:12px;

    padding:10px 20px;

    font-weight:600;

}

.btn-success{

    border-radius:12px;

    padding:10px 20px;

}

.btn-danger{

    border-radius:12px;

}

.table{

    margin-bottom:0;

}

.table thead{

    background:#f5f7fb;

}

.table th{

    border:none;

    font-weight:700;

    padding:15px;

}

.table td{

    vertical-align:middle;

    padding:15px;

}

.summary-box{

    background:#f8fbff;

    border:1px solid #dbe9ff;

    border-radius:15px;

    padding:20px;

}

.summary-total{

    font-size:28px;

    font-weight:bold;

    color:#355cc9;

}

@media(max-width:768px){

    .card-retur{

        padding:15px;

    }

    .page-title{

        font-size:28px;

    }

}

</style>

@endsection

@section('title','Retur Barang')

@section('content')

<div class="container-fluid">

    <h2 class="page-title">

        Retur Barang

    </h2>

    <!-- Card Cari Transaksi -->

    ...

    <!-- Card Daftar Transaksi -->

    <div class="card-retur">

        <h5 class="card-title">

            Daftar Transaksi

        </h5>

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>Kode</th>

                        <th>Tanggal</th>

                        <th>Kasir</th>

                        <th>Total</th>

                        <th width="120">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($sales as $sale)

                <tr>

                    <td>

                        {{ $sale->kode_penjualan }}

                    </td>

                    <td>

                        {{ $sale->tanggal }}

                    </td>

                    <td>

                        {{ $sale->user->name }}

                    </td>

                    <td>

                        Rp {{ number_format($sale->total_bayar,0,',','.') }}

                    </td>

                    <td>

                        <button

                            class="btn btn-primary btn-sm"

                            onclick="loadTransaction({{ $sale->id }})">

                            Pilih

                        </button>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"

                        class="text-center">

                        Belum ada transaksi.

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $sales->links() }}

        </div>

    </div>

    <!-- Card Detail Barang -->

    <div class="card-retur">

        <h5 class="card-title">

            Detail Barang

        </h5>

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>Produk</th>

                        <th>Qty Beli</th>

                        <th>Qty Retur</th>

                        <th>Harga</th>

                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody id="detailBody">

                    <tr>

                        <td colspan="5" class="text-center">

                            Pilih transaksi terlebih dahulu.

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <!-- Card Ringkasan -->

    ...

</div>

@endsection

@section('scripts')

<script>

console.log("SCRIPT RETUR DIMUAT");

let selectedSale = null;

let returnItems = [];

async function loadTransaction(id){

    console.log("klik", id);

    try{

        const url = "/kasir/retur/" + id + "/detail";

        console.log(url);

        const response = await fetch(url);

        console.log(response.status);

        const data = await response.json();

        console.log(data);

        if(!data.success){

            alert("Transaksi tidak ditemukan.");

            return;

        }

        selectedSale = data.sale;

        console.log(selectedSale);

        returnItems = [];

        renderDetailTable();

    }

    catch(error){

        console.error(error);

    }

}

function renderDetailTable(){

    const tbody = document.getElementById("detailBody");

    tbody.innerHTML = "";

    selectedSale.sale_details.forEach(function(item){

        tbody.innerHTML += `

        <tr>

            <td>

                ${item.product.nama_produk}

            </td>

            <td>

                ${item.qty}

            </td>

            <td>

                <input
                    type="number"
                    class="form-control qty-retur"
                    min="0"
                    max="${item.qty}"
                    value="0">

            </td>

            <td>

                Rp ${Number(item.harga).toLocaleString("id-ID")}

            </td>

            <td>

                Rp ${Number(item.subtotal).toLocaleString("id-ID")}

            </td>

        </tr>

        `;

    });

}

</script>

@endsection