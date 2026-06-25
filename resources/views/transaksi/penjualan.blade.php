@extends('layouts.app')

@section('title','Penjualan')

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
    padding:25px;
}

.search-box{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:10px;
    margin-bottom:20px;
}

.sales-table{
    width:100%;
    border-collapse:collapse;
}

.sales-table th{
    background:#f3f5fa;
    padding:14px;
    text-align:left;
}

.sales-table td{
    padding:14px;
    border-bottom:1px solid #eee;
}

.qty-box{
    width:80px;
    padding:8px;
}

.btn-add{
    background:#57c13b;
    color:white;
    border:none;
    padding:8px 14px;
    border-radius:8px;
    cursor:pointer;
}

.btn-delete{
    background:#dc3545;
    color:white;
    border:none;
    padding:8px 15px;
    border-radius:8px;
    cursor:pointer;
    font-size:14px;
    transition:.3s;
}

.btn-delete:hover{
    background:#bb2d3b;
}

.payment-box{
    margin-top:30px;
    padding:25px;
    border:1px solid #eee;
    border-radius:12px;
    background:#fafafa;
}

.payment-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
    font-size:18px;
}

.payment-row.total{
    font-size:22px;
    font-weight:bold;
    color:#1684e0;
}

.form-group{
    margin-top:20px;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
}

</style>

<div class="page-card">

<div class="top-header">
    Transaksi Penjualan
</div>

<div class="page-body">

    <input
        type="text"
        id="searchProduct"
        class="search-box"
        placeholder="Cari Produk...">

    <table class="sales-table">

        <thead>

            <tr>

                <th>Produk</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Qty</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody id="productTable">

        @foreach($products as $product)

            <tr>

                <td>
                    {{ $product->nama_produk }}
                </td>

                <td>
                    Rp {{ number_format($product->harga_jual,0,',','.') }}
                </td>

                <td>
                    {{ $product->stok }}
                </td>

                <td>

                    <input
                        type="number"
                        min="1"
                        value="1"
                        class="qty-box">

                </td>

                <td>

                    <button
                        type="button"
                        class="btn-add add-cart"

                        data-id="{{ $product->id }}"
                        data-nama="{{ $product->nama_produk }}"
                        data-harga="{{ $product->harga_jual }}">

                        Tambah

                    </button>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

    <hr style="margin:30px 0;">

    <h3>Keranjang Belanja</h3>

    <table class="sales-table">

        <thead>

            <tr>

                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody id="cartBody">

        </tbody>

    </table>

    <div class="payment-box">

    <button
        type="button"
        id="saveTransaction"
        class="btn-add"
        style="margin-top:20px;">

        Simpan Transaksi

    </button>

        <div class="payment-row">
            <span>Subtotal</span>
            <strong id="subtotalText">
                Rp 0
            </strong>
        </div>

        <div class="payment-row">
            <span>Diskon</span>
            <strong id="diskonText">
                Rp 0
            </strong>
        </div>

        <div class="payment-row total">
            <span>Total Bayar</span>
            <strong id="totalText">
                Rp 0
            </strong>
        </div>

        <hr>

        <div class="form-group">

            <label>Bayar</label>

            <input
                type="number"
                id="bayar"
                class="form-control">

        </div>

        <div class="payment-row">

            <span>Kembalian</span>

            <strong id="kembalianText">
                Rp 0
            </strong>

        </div>

    </div>

    <form
        id="saleForm"
        method="POST"
        action="{{ route('penjualan.store') }}">

        @csrf

        <input
            type="hidden"
            name="subtotal"
            id="inputSubtotal">

        <input
            type="hidden"
            name="diskon"
            id="inputDiskon">

        <input
            type="hidden"
            name="total_bayar"
            id="inputTotal">

        <input
            type="hidden"
            name="bayar"
            id="inputBayar">

        <input
            type="hidden"
            name="kembalian"
            id="inputKembalian">

        <input
            type="hidden"
            name="items"
            id="inputItems">

    </form>

</div>

</div>

<script>

let grandTotal = 0;

let cartItems = [];

let subtotal = 0;
let diskon = 0;
let totalBayar = 0;

function hitungTotal()
{
    subtotal = grandTotal;

    if(subtotal >= 2000000)
    {
        diskon = subtotal * 0.02;
    }
    else
    {
        diskon = 0;
    }

    totalBayar = subtotal - diskon;

    document.getElementById(
        'subtotalText'
    ).innerHTML =
        'Rp ' + subtotal.toLocaleString('id-ID');

    document.getElementById(
        'diskonText'
    ).innerHTML =
        'Rp ' + diskon.toLocaleString('id-ID');

    document.getElementById(
        'totalText'
    ).innerHTML =
        'Rp ' + totalBayar.toLocaleString('id-ID');

    hitungKembalian();

    document
    .getElementById(
        'inputSubtotal'
    ).value = subtotal;

    document
    .getElementById(
        'inputDiskon'
    ).value = diskon;

    document
    .getElementById(
        'inputTotal'
    ).value = totalBayar;
    }

function hitungKembalian()
{
    let bayar = parseFloat(
        document.getElementById('bayar').value
    ) || 0;

    let kembalian = bayar - totalBayar;

    document.getElementById(
        'kembalianText'
    ).innerHTML =
        'Rp ' +
        kembalian.toLocaleString('id-ID');

    document
    .getElementById(
        'inputBayar'
    ).value = bayar;

    document
    .getElementById(
        'inputKembalian'
    ).value = kembalian;
}

document
.querySelectorAll('.add-cart')
.forEach(button => {

    button.addEventListener(
        'click',
        function(){

            let nama =
                this.dataset.nama;

            let harga =
                parseFloat(
                    this.dataset.harga
                );

            let qty =
                parseInt(
                    this
                    .closest('tr')
                    .querySelector('.qty-box')
                    .value
                );

            let itemSubtotal =
                harga * qty;

            grandTotal += itemSubtotal;

            cartItems.push({

                product_id:
                    this.dataset.id,

                qty:
                    qty,

                harga:
                    harga,

                subtotal:
                    itemSubtotal

            });

            cartItems.push({
                nama: nama,
                harga: harga,
                qty: qty,
                subtotal: itemSubtotal
            });

            let row = `
                <tr>

                    <td>${nama}</td>

                    <td>
                        Rp ${harga.toLocaleString()}
                    </td>

                    <td>${qty}</td>

                    <td>
                        Rp ${itemSubtotal.toLocaleString()}
                    </td>

                    <td>

                        <button
                            type="button"
                            class="delete-cart btn-delete">

                            Hapus

                        </button>

                    </td>

                </tr>
            `;

            document
            .getElementById(
                'cartBody'
            )
            .insertAdjacentHTML(
                'beforeend',
                row
            );

            hitungTotal();

        }
    );

});

document.addEventListener(
    'click',
    function(e){

        if(
            e.target.classList.contains(
                'delete-cart'
            )
        ){

            let row =
                e.target.closest('tr');

            let subtotalText =
                row.children[3]
                .innerText
                .replace('Rp ','')
                .replaceAll(',','');

            grandTotal -=
                parseFloat(
                    subtotalText
                );

            hitungTotal();

            row.remove();
        }

    }
);

document
.getElementById('bayar')
.addEventListener(
    'keyup',
    hitungKembalian
);

document
.getElementById(
    'saveTransaction'
)
.addEventListener(
    'click',
    function(){

        if(cartItems.length == 0)
        {
            alert(
                'Keranjang masih kosong'
            );
            return;
        }

        document
        .getElementById(
            'inputItems'
        )
        .value =
            JSON.stringify(
                cartItems
            );

        document
        .getElementById(
            'saleForm'
        )
        .submit();

    }
);

document
.getElementById('searchProduct')
.addEventListener(
    'keyup',
    function(){

        let keyword =
            this.value.toLowerCase();

        let rows =
            document.querySelectorAll(
                '#productTable tr'
            );

        rows.forEach(function(row){

            let namaProduk =
                row.children[0]
                .innerText
                .toLowerCase();

            if(
                namaProduk.includes(keyword)
            ){
                row.style.display = '';
            }
            else{
                row.style.display = 'none';
            }

        });

    }
);

</script>

@endsection
