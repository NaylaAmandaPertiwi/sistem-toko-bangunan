@extends('layouts.kasir')

@section('title','Penjualan')

@section('content')

<style>

.page-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.page-body{
    padding:25px;
}

/* ===========================
   SEARCH AREA
=========================== */

.search-area{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:25px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-size:14px;
    font-weight:600;
    margin-bottom:8px;
    color:#555;
}

.form-control{
    width:100%;
    padding:12px 15px;
    border:1px solid #dcdcdc;
    border-radius:10px;
    font-size:14px;
    outline:none;
    transition:.2s;
}

.form-control:focus{
    border-color:#4e73df;
    box-shadow:0 0 0 3px rgba(78,115,223,.15);
}

/* ===========================
   CONTENT
=========================== */

.sale-container{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:25px;
}

/* ===========================
   TABLE
=========================== */

.table-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.sale-table{
    width:100%;
    border-collapse:collapse;
}

.sale-table th{
    background:#f4f6fb;
    padding:15px;
    text-align:left;
    font-size:14px;
}

.sale-table td{
    padding:15px;
    border-bottom:1px solid #eee;
    vertical-align:middle;
}

.sale-table tbody tr:hover{
    background:#fafcff;
}

/* ===========================
   QTY BUTTON
=========================== */

.qty-box{
    display:flex;
    align-items:center;
    gap:8px;
}

.qty-btn{

    width:36px;

    height:36px;

    border:none;

    border-radius:10px;

    background:#4e73df;

    color:#fff;

    font-size:16px;

    cursor:pointer;

    transition:.2s;

}

.qty-btn:hover{

    background:#355cc9;

}

.qty-value{
    min-width:25px;
    text-align:center;
    font-weight:600;
}

.qty-input{

    width:80px;

    height:38px;

    text-align:center;

    border:1px solid #dcdcdc;

    border-radius:10px;

    font-weight:600;

    font-size:15px;

}

/* ===========================
   DELETE BUTTON
=========================== */

.btn-delete{
    width:35px;
    height:35px;
    border:none;
    border-radius:8px;
    background:#dc3545;
    color:white;
    cursor:pointer;
}

.btn-delete:hover{
    background:#bb2d3b;
}

/* ===========================
   PAYMENT
=========================== */

.payment-box{
    background:#fff;
    border-radius:16px;
    padding:25px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
    height:fit-content;
}

.payment-title{
    font-size:18px;
    font-weight:700;
    margin-bottom:20px;
}

.payment-item{
    display:flex;
    justify-content:space-between;
    margin-bottom:18px;
    font-size:15px;
}

.payment-item.total{
    border-top:1px solid #eee;
    padding-top:18px;
    font-size:18px;
    font-weight:700;
    color:#4e73df;
}

.payment-box input{
    margin-top:8px;
    margin-bottom:20px;
}

/* ===========================
   SAVE BUTTON
=========================== */

.btn-save{
    width:100%;
    background:#4e73df;
    color:#fff;
    border:none;
    border-radius:12px;
    padding:14px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
}

.btn-save:hover{
    background:#355cc9;
}

/* ===========================
   EMPTY ROW
=========================== */

.empty-cart{
    text-align:center;
    color:#999;
    padding:35px;
}

/* ===========================
   RESPONSIVE
=========================== */

@media(max-width:992px){

    .sale-container{

        grid-template-columns:1fr;

    }

    .search-area{

        grid-template-columns:1fr;

    }

}

.product-item:hover{

    background:#f4f6fb;

}

/*==========================
AUTOCOMPLETE
==========================*/

.product-result{

    position:absolute;

    width:100%;

    background:white;

    border:1px solid #ddd;

    border-radius:10px;

    margin-top:5px;

    max-height:250px;

    overflow-y:auto;

    display:none;

    z-index:999;

    box-shadow:0 5px 15px rgba(0,0,0,.08);

}

.form-group{

    position:relative;

}

.product-item{

    padding:12px 15px;

    cursor:pointer;

    transition:.2s;

}

.product-item:hover{

    background:#f4f8ff;

}

/*==========================
PROMO DISKON
==========================*/

.alert-discount{

    background:#eef6ff;

    border:1px solid #b7d7ff;

    padding:15px;

    border-radius:12px;

    margin-bottom:20px;

}

.alert-discount strong{

    color:#355cc9;

}

.alert-discount ul{

    margin-top:10px;

    padding-left:20px;

}

.alert-discount li{

    margin-bottom:6px;

}

</style>

<div class="header">

    <h2>Penjualan</h2>

</div>

<div class="page-card">

    <div class="page-body">

        {{-- SEARCH --}}
        <div class="search-area">

            <div class="form-group">

                <label>Scan Barcode</label>

                <input
                    type="text"
                    id="barcode"
                    class="form-control"
                    placeholder="Scan barcode...">

            </div>

            <div class="form-group">

                <label>Cari Produk</label>

                <div style="position:relative;">

                    <input
                        type="text"
                        id="searchProduk"
                        class="form-control"
                        placeholder="Cari produk...">

                    <div id="productResult"
                        class="product-result">

                    </div>

                </div>

            </div>

        </div>

        @if($discounts->count())

        <div class="alert-discount">

            <strong>

                Promo Aktif

            </strong>

            <ul>

                @foreach($discounts as $item)

                <li>

                    {{ $item->nama_diskon }}

                    -

                    {{ $item->persentase_diskon }}%

                    (Minimal

                    Rp {{ number_format($item->minimal_belanja,0,',','.') }}

                    )

                </li>

                @endforeach

            </ul>

        </div>

        @endif

        {{-- CONTENT --}}
        <div class="sale-container">

            {{-- TABEL --}}
            <div class="table-card">

                <table class="sale-table">

                    <thead>

                        <tr>

                            <th width="35%">Produk</th>

                            <th width="22%">Qty</th>

                            <th width="20%">Harga</th>

                            <th width="20%">Subtotal</th>

                            <th width="10%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody id="cartBody">

                    </tbody>

                </table>

            </div>

            {{-- PEMBAYARAN --}}
            <div class="payment-box">

                <div class="payment-title">

                    Ringkasan Pembayaran

                </div>

                <div class="payment-item">

                    <span>Subtotal</span>

                    <strong id="subtotal">

                        Rp 0

                    </strong>

                </div>

                <div class="payment-item">

                    <span>Diskon</span>

                    <strong id="diskon">

                        -

                    </strong>

                </div>

                <div class="payment-item total">

                    <span>Total</span>

                    <strong id="total">

                        Rp 0

                    </strong>

                </div>

                <div class="form-group">

                    <label>Bayar</label>

                    <input
                        type="number"
                        id="bayar"
                        class="form-control"
                        placeholder="Masukkan nominal bayar">

                </div>

                <div class="payment-item">

                    <span>Kembalian</span>

                    <strong id="kembalian">

                        Rp 0

                    </strong>

                </div>

                <button
                    type="button"
                    class="btn-save">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Simpan Transaksi

                </button>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

/*=========================================
=            DATA PRODUK DATABASE         =
=========================================*/

const products = @json($products);

let cart = [];

const discounts = @json($discounts);

/*=========================================
=            ELEMENT HTML                 =
=========================================*/

const searchInput = document.getElementById('searchProduk');
const resultBox   = document.getElementById('productResult');
const bayarInput  = document.getElementById('bayar');

/*=========================================
=            AUTOCOMPLETE                 =
=========================================*/

searchInput.addEventListener('keyup', function () {

    renderSuggestion(this.value);

});

/*=========================================
=            TAMPILKAN SUGGESTION         =
=========================================*/

function renderSuggestion(keyword){

    keyword=keyword.toLowerCase().trim();

    if(keyword==""){

        resultBox.style.display="none";

        return;

    }

    let filter=products.filter(item=>

        item.nama_produk
            .toLowerCase()
            .includes(keyword)

    );

    if(filter.length==0){

        resultBox.innerHTML=`

        <div class="product-item">

            Produk tidak ditemukan

        </div>

        `;

        resultBox.style.display="block";

        return;

    }

    let html="";

    filter.slice(0,10).forEach(item=>{

        html+=`

        <div
            class="product-item"
            onclick="addProduct(${item.id})">

            <strong>

                ${item.nama_produk}

            </strong>

            <br>

            <small>

                Rp ${format(item.harga_jual)}

            </small>

        </div>

        `;

    });

    resultBox.innerHTML=html;

    resultBox.style.display="block";

}

/*=========================================
=            TAMBAH KE KERANJANG          =
=========================================*/

function addProduct(id){

    const product = products.find(p => p.id == id);

    const exist = cart.find(c => c.id == id);

    if(exist){

        if(exist.qty >= product.stok){

            alert("Stok hanya tersedia " + product.stok);

            return;

        }

        exist.qty++;

    }else{

        cart.push({

            id: product.id,

            nama: product.nama_produk,

            harga: Number(product.harga_jual),

            qty: 1

        });

    }

    searchInput.value = "";

    resultBox.style.display = "none";

    renderCart();

    searchInput.focus();

}

/*=========================================
=            RENDER KERANJANG             =
=========================================*/

function renderCart(){

    let html="";

    if(cart.length==0){

        html=`

        <tr>

            <td colspan="5" class="empty-cart">

                Belum ada produk

            </td>

        </tr>

        `;

    }else{

        cart.forEach((item,index)=>{

            html += `

            <tr>

                <td>${item.nama}</td>

                <td>

                    <div class="qty-box">

                        <button
                        class="qty-btn"
                        onclick="minusQty(${index})">

                            -

                        </button>

                        <input

                            type="number"

                            min="1"

                            max="${products.find(p=>p.id==item.id).stok}"

                            class="qty-input"

                            value="${item.qty}"

                            onchange="changeQty(${index},this.value)">

                        <button
                        class="qty-btn"
                        onclick="plusQty(${index})">

                            +

                        </button>

                    </div>

                </td>

                <td>

                    Rp ${format(item.harga)}

                </td>

                <td>

                    Rp ${format(

                        item.qty *

                        item.harga

                    )}

                </td>

                <td>

                    <button
                    class="btn-delete"
                    onclick="removeItem(${index})">

                        🗑

                    </button>

                </td>

            </tr>

            `;

        });

    }

    document.getElementById('cartBody').innerHTML = html;

    calculateTotal();

}

/*=========================================
=            TAMBAH QTY                   =
=========================================*/

function plusQty(index){

    const product = products.find(

        p => p.id == cart[index].id

    );

    if(cart[index].qty >= product.stok){

        alert("Stok tidak mencukupi");

        return;

    }

    cart[index].qty++;

    renderCart();

}

/*=========================================
=            KURANG QTY                   =
=========================================*/

function minusQty(index){

    cart[index].qty--;

    if(cart[index].qty<=0){

        cart.splice(index,1);

    }

    renderCart();

}

function changeQty(index,value){

    value = parseInt(value);

    if(isNaN(value) || value < 1){

        value = 1;

    }

    const product = products.find(
        p => p.id == cart[index].id
    );

    if(value > product.stok){

        alert(

            "Stok hanya tersedia " +

            product.stok

        );

        value = product.stok;

    }

    cart[index].qty = value;

    renderCart();

}

/*=========================================
=            HAPUS BARANG                 =
=========================================*/

function removeItem(index){

    cart.splice(index,1);

    renderCart();

}

/*=========================================
=            FORMAT RUPIAH                =
=========================================*/

function format(number){

    return new Intl.NumberFormat(

        "id-ID"

    ).format(number);

}

function getDiscount(subtotal){

    let bestDiscount = {

        persen : 0,

        nominal : 0,

        nama : ""

    };

    discounts.forEach(item=>{

        if(

            item.status == "Aktif" &&

            subtotal >= Number(item.minimal_belanja)

        ){

            let nominal =

                subtotal *

                Number(item.persentase_diskon)

                /100;

            if(

                nominal >

                bestDiscount.nominal

            ){

                bestDiscount={

                    nama:item.nama_diskon,

                    persen:Number(item.persentase_diskon),

                    nominal:nominal

                };

            }

        }

    });

    return bestDiscount;

}

/*=========================================
=            HITUNG TOTAL                 =
=========================================*/

function calculateTotal(){

    let subtotal=0;

    cart.forEach(item=>{

        subtotal +=

            item.qty *

            item.harga;

    });

    let promo = getDiscount(subtotal);

    let total =

        subtotal -

        promo.nominal;

    document.getElementById(

        "subtotal"

    ).innerHTML =

        "Rp "+format(subtotal);

    if(promo.persen>0){

        document.getElementById(

            "diskon"

        ).innerHTML=

        promo.nama+

        "<br>"+

        promo.persen+

        "% (Rp "+

        format(

            promo.nominal

        )+

        ")";

    }

    else{

        document.getElementById(

            "diskon"

        ).innerHTML=

        "-";

    }

    document.getElementById(

        "total"

    ).innerHTML=

    "Rp "+format(total);

    calculateChange(total);

}

function calculateChange(total){

    let bayar = Number(bayarInput.value);

    if(isNaN(bayar)){

        bayar = 0;

    }

    let kembali = bayar - total;

    if(kembali < 0){

        kembali = 0;

    }

    document.getElementById("kembalian").innerHTML =

        "Rp " + format(kembali);

}

/*=========================================
=            SIMPAN TRANSAKSI             =
=========================================*/

document.querySelector(".btn-save").addEventListener("click", async function () {

    if (cart.length === 0) {

        alert("Keranjang masih kosong.");

        return;
    }

    let subtotal = 0;

    cart.forEach(item => {

        subtotal += item.qty * item.harga;

    });

    const promo = getDiscount(subtotal);

    const total = subtotal - promo.nominal;

    const bayar = Number(bayarInput.value);

    const kembalian = bayar - total;

    if (bayar < total) {

        alert("Nominal pembayaran kurang.");

        bayarInput.focus();

        return;

    }

    this.disabled = true;

    this.innerHTML = "Menyimpan...";

    try {

        const response = await fetch(
            "{{ route('kasir.penjualan.store') }}",
            {

                method: "POST",

                headers: {

                    "Content-Type": "application/json",

                    "Accept": "application/json",

                    "X-CSRF-TOKEN":
                        document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content")

                },

                body: JSON.stringify({

                    subtotal: subtotal,

                    diskon: promo.nominal,

                    total: total,

                    bayar: bayar,

                    kembalian: kembalian,

                    items: cart

                })

            }

        );

        const data = await response.json();

                if (data.success) {

            const cetak = confirm(

                "Transaksi berhasil disimpan.\n\n" +

                "Kode : " +

                data.kode_penjualan +

                "\n\nCetak struk sekarang?"

            );

            if (cetak) {

                window.open(

                    data.print_url,

                    "_blank",

                    "width=450,height=700"

                );

            }

            /*
            ===========================
            RESET HALAMAN
            ===========================
            */

            cart = [];

            bayarInput.value = "";

            searchInput.value = "";

            renderCart();

            searchInput.focus();

        } else {

            alert(data.message);

        }

    } catch (error) {

        console.error(error);

        alert("Terjadi kesalahan saat menyimpan transaksi.");

    }

    this.disabled = false;

    this.innerHTML = "Simpan Transaksi";

});

/*=========================================
=            EVENT BAYAR                  =
=========================================*/

bayarInput.addEventListener("input", function(){

    calculateTotal();

});

/*=========================================
=            LOAD AWAL                    =
=========================================*/

renderCart();

document.addEventListener('click',function(e){

    if(!searchInput.contains(e.target) &&
       !resultBox.contains(e.target)){

        resultBox.style.display="none";

    }

});

</script>

@endsection