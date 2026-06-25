@extends('layouts.app')

@section('title','Tambah Retur')

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

.page-body{
    padding:30px;
}

.form-group{
    margin-bottom:25px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
    color:#444;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
}

.return-table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.return-table th{
    background:#f3f5fa;
    padding:15px;
    text-align:left;
}

.return-table td{
    padding:15px;
    border-bottom:1px solid #eee;
}

.qty-box{
    width:80px;
    padding:8px;
    border:1px solid #ddd;
    border-radius:8px;
}

.button-group{
    margin-top:30px;
    display:flex;
    justify-content:flex-end;
    gap:15px;
}

.btn-save{
    background:#4CAF50;
    color:white;
    border:none;
    padding:12px 22px;
    border-radius:8px;
    cursor:pointer;
}

.btn-cancel{
    background:#ddd;
    color:#333;
    padding:12px 22px;
    border-radius:8px;
    text-decoration:none;
}

.empty-data{
    text-align:center;
    color:#888;
    padding:30px;
}

</style>

<div class="page-card">

    <div class="top-header">
        Tambah Retur
    </div>

    <div class="page-body">

        <form
            method="POST"
            action="{{ route('retur.store') }}"
            id="returnForm">

            @csrf

            <div class="form-group">

                <label>Pilih Transaksi Penjualan</label>

                <select
                    name="sale_id"
                    class="form-control"
                    id="saleSelect">

                    <option value="">
                        -- Pilih Transaksi --
                    </option>

                    @foreach($sales as $sale)

                        <option
                            value="{{ $sale->id }}">

                            {{ $sale->kode_penjualan }}
                            -
                            {{ $sale->tanggal }}

                        </option>

                    @endforeach

                </select>

            </div>

            <table class="return-table">

                <thead>

                    <tr>

                        <th>Produk</th>
                        <th>Qty Dibeli</th>
                        <th>Qty Retur</th>
                        <th>Harga</th>
                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody id="detailBody">

                    <tr>

                        <td
                            colspan="5"
                            class="empty-data">

                            Pilih transaksi terlebih dahulu

                        </td>

                    </tr>

                </tbody>

            </table>

            <div class="form-group">

                <label>Keterangan Retur</label>

                <textarea
                    name="keterangan"
                    rows="4"
                    class="form-control"
                    placeholder="Masukkan alasan retur..."></textarea>

            </div>

            <div
                style="
                    margin-top:25px;
                    text-align:right;
                    font-size:22px;
                    font-weight:bold;
                    color:#1684e0;
                ">

                Total Retur :
                Rp <span id="totalRetur">0</span>

            </div>

            <input
                type="hidden"
                name="items"
                id="itemsReturn">

            <input
                type="hidden"
                name="total_retur"
                id="totalReturnInput">

            <div class="button-group">

                <a
                    href="{{ route('retur.index') }}"
                    class="btn-cancel">

                    Batal

                </a>

                <button
                    type="submit"
                    class="btn-save">

                    Simpan Retur

                </button>

            </div>

        </form>

    </div>

</div>

<script>

const sales = @json($sales);

const saleSelect =
    document.getElementById('saleSelect');

const detailBody =
    document.getElementById('detailBody');

let totalRetur = 0;

saleSelect.addEventListener(
    'change',
    function(){

        let sale =
            sales.find(

                item => item.id == this.value

            );

        if(!sale){

            detailBody.innerHTML = `
                <tr>

                    <td colspan="5">

                        Pilih transaksi terlebih dahulu

                    </td>

                </tr>
            `;

            return;

        }

        let html = '';

        sale.details.forEach(detail=>{

            html += `
            <tr>

                <td>

                    ${detail.product.nama_produk}

                </td>

                <td>

                    ${detail.qty}

                </td>

                <td>

                    <input
                        type="number"
                        min="0"
                        max="${detail.qty}"
                        value="0"
                        class="qty-retur"
                        data-product="${detail.product.id}"
                        data-harga="${detail.harga}"
                        data-max="${detail.qty}"
                        oninput="hitungRetur()">

                </td>

                <td>

                    Rp ${Number(detail.harga).toLocaleString('id-ID')}

                </td>

                <td class="subtotal">

                    Rp 0

                </td>

            </tr>
            `;

        });

        detailBody.innerHTML = html;

    }
);

function hitungRetur()
{
    totalRetur = 0;

    let items = [];

    document
    .querySelectorAll('.qty-retur')
    .forEach(function(input){

        let qty =
            parseInt(input.value) || 0;

        let harga =
            parseFloat(
                input.dataset.harga
            );

        let subtotal =
            qty * harga;

        input
        .closest('tr')
        .querySelector('.subtotal')
        .innerHTML =
            'Rp ' +
            subtotal.toLocaleString('id-ID');

        totalRetur += subtotal;

        if(qty > 0)
        {
            items.push({

                product_id:
                    input.dataset.product,

                qty:
                    qty,

                harga:
                    harga,

                subtotal:
                    subtotal

            });
        }

    });

    document
    .getElementById(
        'totalRetur'
    ).innerHTML =
        totalRetur.toLocaleString('id-ID');

    document
    .getElementById(
        'itemsReturn'
    ).value =
        JSON.stringify(items);

    document
    .getElementById(
        'totalReturnInput'
    ).value =
        totalRetur;
}

</script>

@endsection