@extends('layouts.kasir')

@section('styles')

<style>

.page-title{

    font-size:28px;

    font-weight:700;

    color:#2d3748;

    margin-bottom:6px;

}

.page-description{

    font-size:15px;

    color:#6b7280;

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

    width:100% !important;

    min-height:140px;

    padding:16px;

    border-radius:12px !important;

    resize:vertical;

    line-height:1.7;

    font-size:15px;

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

.summary-box textarea{

    width:100%;

    min-height:140px;

    padding:15px;

    border-radius:12px;

    resize:vertical;

    font-size:15px;

    line-height:1.6;

}

.summary-box label{

    font-weight:600;

    margin-bottom:10px;

}

.summary-box .btn-success{

    min-width:170px;

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

    <p class="page-description">

        Pilih transaksi penjualan untuk diproses menjadi retur barang.

    </p>

    <!-- Card Cari Transaksi -->

    <div class="card-retur">

        <h5 class="card-title">

            Cari Transaksi

        </h5>

        <div class="row g-3">

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Cari Kode Transaksi

            </label>

            <input
                id="searchTransaction"
                type="text"
                class="form-control"
                placeholder="Contoh: 124329"
                autocomplete="off">

        </div>

        <div class="col-md-3">

            <label class="form-label fw-semibold">

                Tanggal

            </label>

            <input
                id="searchDate"
                type="date"
                class="form-control">

        </div>

    </div>

    </div>

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

                <tbody id="transactionTable">

                    <tr>

                        <td colspan="5" class="text-center">

                            Memuat data transaksi...

                        </td>

                    </tr>

                </tbody>

            </table>

            <div class="text-center mt-3">

                <button
                    id="btnLoadMore"
                    class="btn btn-outline-primary"
                    style="display:none">

                    Muat Lebih Banyak

                </button>

            </div>

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

    <div class="card-retur">

        <h5 class="card-title">

            Ringkasan Retur

        </h5>

        <div class="summary-box">

            <div class="row">

                <div class="col-12">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h6 class="mb-0 fw-bold">

                            Total Retur

                        </h6>

                        <span
                            id="totalRetur"
                            class="summary-total">

                            Rp 0

                        </span>

                    </div>

                </div>

                <div class="col-12">

                    <label
                        for="keteranganRetur"
                        class="form-label fw-bold mb-2">

                        Keterangan Retur

                    </label>

                    <textarea

                        id="keteranganRetur"

                        class="form-control"

                        rows="5"

                        placeholder="Contoh:
        • Barang rusak
        • Kemasan sobek
        • Salah ukuran
        • Barang tidak sesuai pesanan"></textarea>

                </div>

                <div class="col-12 text-end mt-4">

                    <button

                        type="button"

                        id="btnSimpanRetur"

                        class="btn btn-success px-4">

                        <i class="bi bi-check-circle me-1"></i>

                        Simpan Retur

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

console.log("SCRIPT RETUR DIMUAT");

let selectedSale = null;

let returnItems = [];

let totalRetur = 0;

let transactionOffset = 0;

const transactionLimit = 10;

let hasMoreTransaction = true;

let isLoadingTransaction = false;

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

    selectedSale.sale_details.forEach(function(item,index){

        returnItems.push({

            sale_detail_id : item.id,

            product_id : item.product_id,

            qty_beli   : item.qty,

            qty_retur  : 0,

            harga      : Number(item.harga),

            subtotal   : 0

        });

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

                    class="form-control"

                    min="0"

                    max="${item.qty}"

                    value="0"

                    onclick="this.select()"
                    
                    oninput="updateQty(${index}, this)"

                >

            </td>

            <td>

                Rp ${Number(item.harga).toLocaleString("id-ID")}

            </td>

            <td id="subtotal-${index}">

                Rp 0

            </td>

        </tr>

        `;

    });

}

function updateQty(index, input){

    let value = parseInt(input.value);

    /*
    |--------------------------------------------------------------------------
    | Jika kosong atau bukan angka
    |--------------------------------------------------------------------------
    */

    if(input.value === ""){

        value = 0;

        input.value = 0;

    }

    /*
    |--------------------------------------------------------------------------
    | Tidak boleh negatif
    |--------------------------------------------------------------------------
    */

    if(value < 0){

        value = 0;

        input.value = 0;

    }

    /*
    |--------------------------------------------------------------------------
    | Tidak boleh melebihi Qty Pembelian
    |--------------------------------------------------------------------------
    */

    if(value > returnItems[index].qty_beli){

        alert("Qty retur tidak boleh melebihi Qty Pembelian.");

        value = returnItems[index].qty_beli;

        input.value = value;

    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Qty Retur
    |--------------------------------------------------------------------------
    */

    returnItems[index].qty_retur = value;

    /*
    |--------------------------------------------------------------------------
    | Hitung Subtotal Retur
    |--------------------------------------------------------------------------
    */

    returnItems[index].subtotal =

        value *

        returnItems[index].harga;

    /*
    |--------------------------------------------------------------------------
    | Update Nilai Input
    |--------------------------------------------------------------------------
    */

    input.value = value;

    /*
    |--------------------------------------------------------------------------
    | Update Subtotal
    |--------------------------------------------------------------------------
    */

    document.getElementById(

        "subtotal-" + index

    ).innerHTML =

        "Rp " +

        returnItems[index]

            .subtotal

            .toLocaleString("id-ID");

    /*
    |--------------------------------------------------------------------------
    | Hitung Total
    |--------------------------------------------------------------------------
    */

    calculateTotalRetur();

}

function calculateTotalRetur(){

    totalRetur = 0;

    returnItems.forEach(function(item){

        totalRetur += item.subtotal;

    });

    document.getElementById(

        "totalRetur"

    ).innerHTML =

        "Rp " +

        totalRetur.toLocaleString("id-ID");

}

function prepareReturnPayload() {

    return {

        sale_id: selectedSale.id,

        items: returnItems

            .filter(item => item.qty_retur > 0)

            .map(item => ({

                sale_detail_id: item.sale_detail_id,

                qty: item.qty_retur

            })),

        keterangan: document
            .getElementById("keteranganRetur")
            .value
            .trim()

    };

}

/*
|--------------------------------------------------------------------------
| Kirim Data Retur ke Backend
|--------------------------------------------------------------------------
*/

async function submitReturn() {

    const payload = prepareReturnPayload();

    const btnSimpan = document.getElementById("btnSimpanRetur");

    try {

        btnSimpan.disabled = true;

        btnSimpan.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Menyimpan...
        `;

        const response = await fetch("/kasir/retur", {

            method: "POST",

            headers: {

                "Content-Type": "application/json",

                "Accept": "application/json",

                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")

            },

            body: JSON.stringify(payload)

        });

        const result = await response.json();

        if (!response.ok) {

            throw new Error(result.message);

        }

        alert(result.message);

        setTimeout(function () {

            window.location.reload();

        }, 300);

    }

    catch (error) {

        console.error(error);

        alert(error.message);

        btnSimpan.disabled = false;

        btnSimpan.innerHTML = `
            <i class="bi bi-check-circle me-1"></i>
            Simpan Retur
        `;

    }

}

/*
|--------------------------------------------------------------------------
| Event Tombol Simpan Retur
|--------------------------------------------------------------------------
*/

document.getElementById("btnSimpanRetur").addEventListener("click", function () {

    // Pastikan transaksi sudah dipilih
    if (!selectedSale) {

        alert("Silakan pilih transaksi terlebih dahulu.");

        return;

    }

    // Ambil payload
    const payload = prepareReturnPayload();

    // Minimal satu barang diretur
    if (payload.items.length === 0) {

        alert("Silakan masukkan Qty Retur minimal 1.");

        return;

    }

    // Konfirmasi sebelum menyimpan
    if (!confirm("Apakah Anda yakin ingin menyimpan retur ini?")) {

        return;

    }

    // Kirim ke backend
    submitReturn();

});

const searchInput = document.getElementById("searchTransaction");

const dateInput = document.getElementById("searchDate");

let timer = null;

searchInput.addEventListener("keyup", function(){

    clearTimeout(timer);

    timer = setTimeout(function(){

        searchTransaction();

    },300);

});

dateInput.addEventListener("change", function(){

    searchTransaction();

});

async function fetchTransactions(

    keyword = "",

    tanggal = "",

    offset = transactionOffset

){

    const response = await fetch(

        "/kasir/retur/transactions?" +

        new URLSearchParams({

            search: keyword,

            tanggal: tanggal,

            offset: offset,

            limit: transactionLimit

        })

    );

    if(!response.ok){

        throw new Error(

            "Gagal mengambil data transaksi."

        );

    }

    return await response.json();

}

async function searchTransaction(){

    transactionOffset = 0;

    const keyword =

        document.getElementById(

            "searchTransaction"

        ).value;

    const tanggal =

        document.getElementById(

            "searchDate"

        ).value;

    try{

        const result =

            await fetchTransactions(

                keyword,

                tanggal,

                transactionOffset

            );

        hasMoreTransaction =

            result.hasMore;

        transactionOffset =

            result.nextOffset;

        renderTransactionTable(

            result.data

        );

        toggleLoadMoreButton();

    }

    catch(error){

        console.error(error);

    }

}

async function loadMoreTransactions(){

    if(!hasMoreTransaction || isLoadingTransaction){

        return;

    }

    isLoadingTransaction = true;

    const button = document.getElementById("btnLoadMore");

    button.disabled = true;

    button.innerHTML = `
        <span class="spinner-border spinner-border-sm me-2"></span>
        Memuat...
    `;

    const keyword = document
        .getElementById("searchTransaction")
        .value;

    const tanggal = document
        .getElementById("searchDate")
        .value;

    try{

        const result = await fetchTransactions(

            keyword,

            tanggal,

            transactionOffset

        );

        renderTransactionTable(

            result.data,

            true

        );

        hasMoreTransaction = result.hasMore;

        transactionOffset = result.nextOffset;

        toggleLoadMoreButton();

    }

    catch(error){

        console.error(error);

        alert("Gagal memuat transaksi.");

    }

    finally{

        isLoadingTransaction = false;

        button.disabled = false;

        button.innerHTML = "Muat Lebih Banyak";

    }

}

function buildTransactionRow(sale){

    return `

    <tr>

        <td>

            ${sale.kode_penjualan}

        </td>

        <td>

            ${sale.tanggal}

        </td>

        <td>

            ${sale.user.name}

        </td>

        <td>

            Rp ${Number(sale.total_bayar).toLocaleString("id-ID")}

        </td>

        <td>

            <button

                class="btn btn-primary btn-sm"

                onclick="loadTransaction(${sale.id})">

                Pilih

            </button>

        </td>

    </tr>

    `;

}

function renderTransactionTable(data, append = false){

    const tbody = document.getElementById("transactionTable");

    if(!append){

        tbody.innerHTML = "";

    }

    if(data.length === 0){

        if(!append){

            tbody.innerHTML = `

                <tr>

                    <td colspan="5" class="text-center">

                        Data tidak ditemukan.

                    </td>

                </tr>

            `;

        }

        return;

    }

    data.forEach(function(sale){

        tbody.insertAdjacentHTML(

            "beforeend",

            buildTransactionRow(sale)

        );

    });

}

function toggleLoadMoreButton(){

    const button =

        document.getElementById(

            "btnLoadMore"

        );

    button.style.display =

        hasMoreTransaction

            ? "inline-block"

            : "none";

}

document
    .getElementById("btnLoadMore")
    .addEventListener("click", function(){

        loadMoreTransactions();

    });

document.addEventListener("DOMContentLoaded", function(){

    searchTransaction();

});

window.addEventListener("scroll", function(){

    // Tidak perlu memuat jika data sudah habis
    if(!hasMoreTransaction){

        return;

    }

    // Tidak perlu memuat jika masih proses request
    if(isLoadingTransaction){

        return;

    }

    // Jika pengguna sudah mendekati bagian bawah halaman
    if(window.innerHeight + window.scrollY >= document.body.offsetHeight - 150){

        loadMoreTransactions();

    }

});

</script>

@endsection