@extends('layouts.kasir')

@section('styles')

<style>

/* =========================================================
   RETUR PAGE
========================================================= */

.retur-page{

    max-width:1400px;

    margin:0 auto;

}


/* =========================================================
   HEADER
========================================================= */

.retur-header{

    display:flex;

    justify-content:space-between;

    align-items:flex-start;

    margin-bottom:25px;

}

.retur-header h1{

    margin:0;

    font-size:30px;

    font-weight:700;

    color:#24324a;

}

.retur-header p{

    margin:6px 0 0;

    color:#667085;

    font-size:15px;

}

.btn-kembali{

    display:inline-flex;

    align-items:center;

    gap:8px;

    padding:10px 18px;

    border-radius:10px;

    background:#ffffff;

    border:1px solid #e2e8f0;

    color:#344054;

    text-decoration:none;

    font-weight:600;

    transition:.2s;

}

.btn-kembali:hover{

    background:#f8fafc;

}


/* =========================================================
   STEPPER
========================================================= */

.return-stepper{

    display:flex;

    align-items:center;

    justify-content:center;

    margin-bottom:25px;

    padding:5px 0;

}

.return-step{

    display:flex;

    align-items:center;

    gap:9px;

    color:#98a2b3;

    font-size:14px;

    font-weight:600;

}

.return-step.active{

    color:#355cc9;

}

.return-step-number{

    width:30px;

    height:30px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#eef2f7;

    color:#667085;

    font-weight:700;

}

.return-step.active .return-step-number{

    background:#355cc9;

    color:#ffffff;

}

.return-step-line{

    width:110px;

    height:1px;

    background:#dbe2ea;

    margin:0 15px;

}


/* =========================================================
   GRID UTAMA
========================================================= */

.retur-layout{

    display:grid;

    grid-template-columns:minmax(0, 1fr) 360px;

    gap:22px;

    align-items:start;

}


/* =========================================================
   CARD
========================================================= */

.retur-card{

    background:#ffffff;

    border:1px solid #edf1f7;

    border-radius:18px;

    padding:22px;

    box-shadow:0 6px 20px rgba(15,23,42,.04);

    margin-bottom:20px;

}

.retur-card-title{

    font-size:17px;

    font-weight:700;

    color:#24324a;

    margin:0 0 18px;

}

.retur-card-subtitle{

    font-size:13px;

    color:#667085;

    margin-top:-10px;

    margin-bottom:18px;

}


/* =========================================================
   FORM
========================================================= */

.retur-label{

    display:block;

    margin-bottom:7px;

    font-size:13px;

    font-weight:600;

    color:#344054;

}

.retur-input{

    width:100%;

    height:45px;

    border:1px solid #d9e0ea;

    border-radius:10px;

    padding:0 13px;

    font-size:14px;

    color:#344054;

    background:#ffffff;

    outline:none;

    transition:.2s;

}

.retur-input:focus{

    border-color:#355cc9;

    box-shadow:0 0 0 3px rgba(53,92,201,.10);

}


/* =========================================================
   SEARCH TRANSAKSI
========================================================= */

.search-wrapper{

    display:flex;

    gap:8px;

}

.search-wrapper .retur-input{

    flex:1;

}


/* =========================================================
   JENIS RETUR
========================================================= */

.jenis-retur-title{

    font-size:14px;

    font-weight:700;

    color:#344054;

    margin-bottom:12px;

}

.jenis-retur-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:12px;

}

.jenis-retur-card{

    position:relative;

    border:1px solid #d9e0ea;

    border-radius:13px;

    padding:17px;

    cursor:pointer;

    background:#ffffff;

    transition:.2s;

}

.jenis-retur-card:hover{

    border-color:#355cc9;

    background:#f8faff;

}

.jenis-retur-card.active{

    border-color:#22c55e;

    background:#f0fdf4;

}

.jenis-retur-card.exchange.active{

    border-color:#355cc9;

    background:#f5f8ff;

}

/* =========================================================
   JENIS RETUR DISABLED
========================================================= */

.jenis-retur-card.disabled{

    opacity:.55;

    background:#f8fafc;

    border-color:#e2e8f0;

    cursor:not-allowed;

}

.jenis-retur-card.disabled:hover{

    border-color:#e2e8f0;

    background:#f8fafc;

    transform:none;

}

.jenis-retur-card.disabled .jenis-retur-check{

    background:#e2e8f0;

    border-color:#cbd5e1;

    color:#94a3b8;

}

.jenis-retur-card.disabled .jenis-retur-icon{

    background:#f1f5f9;

    color:#94a3b8;

}

.jenis-retur-card.disabled h4{

    color:#64748b;

}

.jenis-retur-card.disabled p{

    color:#94a3b8;

}

.jenis-retur-icon{

    width:38px;

    height:38px;

    border-radius:10px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#eaf8ef;

    color:#16a34a;

    font-size:18px;

    margin-bottom:10px;

}

.jenis-retur-card.exchange .jenis-retur-icon{

    background:#eaf0ff;

    color:#355cc9;

}

.jenis-retur-card h4{

    margin:0 0 5px;

    font-size:15px;

    font-weight:700;

    color:#24324a;

}

.jenis-retur-card p{

    margin:0;

    font-size:12px;

    line-height:1.5;

    color:#667085;

}

.jenis-retur-check{

    position:absolute;

    top:13px;

    right:13px;

    width:20px;

    height:20px;

    border-radius:50%;

    border:1px solid #cbd5e1;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:10px;

    color:transparent;

}

.jenis-retur-card.active .jenis-retur-check{

    background:#22c55e;

    border-color:#22c55e;

    color:#ffffff;

}

.jenis-retur-card.exchange.active .jenis-retur-check{

    background:#355cc9;

    border-color:#355cc9;

}

/* =========================================================
   TUKAR BARANG
========================================================= */

.exchange-search-wrapper{

    position:relative;

    margin-top:20px;

    margin-bottom:18px;

}

.exchange-search-input{

    width:100%;

    height:44px;

    padding:0 15px;

    border:1px solid #d9e1ef;

    border-radius:10px;

    outline:none;

    font-size:14px;

    color:#2d3748;

    background:#fff;

    box-sizing:border-box;

}

.exchange-search-input:focus{

    border-color:#355cc9;

    box-shadow:0 0 0 3px rgba(53,92,201,.10);

}

.exchange-product-result{

    position:absolute;

    top:50px;

    left:0;

    right:0;

    background:#fff;

    border:1px solid #e2e8f0;

    border-radius:10px;

    box-shadow:0 8px 20px rgba(0,0,0,.08);

    overflow:hidden;

    display:none;

    z-index:100;

}

.exchange-product-item{

    padding:12px 15px;

    cursor:pointer;

    border-bottom:1px solid #edf2f7;

    transition:.2s;

}

.exchange-product-item:last-child{

    border-bottom:none;

}

.exchange-product-item:hover{

    background:#f7f9fc;

}

.exchange-product-item strong{

    display:block;

    color:#2d3748;

    font-size:14px;

}

.exchange-product-item small{

    color:#718096;

    font-size:12px;

}

.exchange-empty{

    text-align:center !important;

    padding:35px 15px !important;

    color:#94a3b8 !important;

}

.exchange-empty i{

    font-size:25px;

    margin-bottom:8px;

    display:block;

}

.exchange-empty small{

    display:block;

    margin-top:5px;

    color:#94a3b8;

}

.exchange-qty-input{

    width:60px;

    height:34px;

    text-align:center;

    border:1px solid #d9e1ef;

    border-radius:8px;

    outline:none;

}

.exchange-qty-input:focus{

    border-color:#355cc9;

}

.exchange-delete{

    width:32px;

    height:32px;

    border:none;

    border-radius:8px;

    background:#fee2e2;

    color:#dc2626;

    cursor:pointer;

}

.exchange-delete:hover{

    background:#fecaca;

}

.exchange-note{

    display:flex;

    align-items:flex-start;

    gap:9px;

    margin-top:18px;

    padding:12px 14px;

    background:#eff6ff;

    border:1px solid #bfdbfe;

    border-radius:10px;

    color:#1d4ed8;

    font-size:13px;

    line-height:1.5;

}

.exchange-note i{

    margin-top:2px;

}


/* =========================================================
   TABEL
========================================================= */

.retur-table-wrapper{

    overflow-x:auto;

}

.retur-table{

    width:100%;

    border-collapse:collapse;

    font-size:13px;

}

.retur-table thead{

    background:#f3f6fa;

}

.retur-table th{

    padding:13px 12px;

    text-align:left;

    font-size:12px;

    font-weight:700;

    color:#344054;

    border:none;

    white-space:nowrap;

}

.retur-table td{

    padding:14px 12px;

    border-bottom:1px solid #edf1f5;

    color:#475467;

    vertical-align:middle;

}

/* =========================================================
   LAYOUT TABEL BARANG YANG DIKEMBALIKAN
========================================================= */

.retur-detail-table{
    width:100%;
    table-layout:fixed;
}

/* No */
.retur-detail-table th:nth-child(1),
.retur-detail-table td:nth-child(1){
    width:8%;
    text-align:center;
}

/* Produk */
.retur-detail-table th:nth-child(2),
.retur-detail-table td:nth-child(2){
    width:28%;
}

/* Harga */
.retur-detail-table th:nth-child(3),
.retur-detail-table td:nth-child(3){
    width:18%;
}

/* Qty Dibeli */
.retur-detail-table th:nth-child(4),
.retur-detail-table td:nth-child(4){
    width:16%;
}

/* Qty Retur */
.retur-detail-table th:nth-child(5),
.retur-detail-table td:nth-child(5){
    width:16%;
}

/* Subtotal */
.retur-detail-table th:nth-child(6),
.retur-detail-table td:nth-child(6){
    width:14%;
}

/* =========================================================
   LEBAR KOLOM TABEL TRANSAKSI
========================================================= */

.retur-table th:nth-child(1),
.retur-table td:nth-child(1){

    width:180px;

}

.retur-table th:nth-child(2),
.retur-table td:nth-child(2){

    width:130px;

}

.retur-table th:nth-child(3),
.retur-table td:nth-child(3){

    width:100px;

}

.retur-table th:nth-child(4),
.retur-table td:nth-child(4){

    width:130px;

}

.retur-table th:nth-child(5),
.retur-table td:nth-child(5){

    width:100px;

    text-align:center;

}


.retur-table tbody tr:last-child td{

    border-bottom:none;

}

/* =========================================================
   QTY
========================================================= */

.qty-input{

    width:75px;

    height:36px;

    border:1px solid #d9e0ea;

    border-radius:8px;

    text-align:center;

    outline:none;

}

.qty-input:focus{

    border-color:#355cc9;

}


/* =========================================================
   INFO PENJUALAN
========================================================= */

.info-list{

    display:flex;

    flex-direction:column;

}

.info-row{

    display:flex;

    justify-content:space-between;

    gap:15px;

    padding:11px 0;

    border-bottom:1px solid #edf1f5;

}

.info-row:last-child{

    border-bottom:none;

}

.info-row span:first-child{

    color:#667085;

    font-size:12px;

}

.info-row span:last-child{

    color:#24324a;

    font-size:13px;

    font-weight:600;

    text-align:right;

}


/* =========================================================
   DETAIL PENJUALAN BUTTON
========================================================= */

.btn-detail-sale{

    width:100%;

    height:42px;

    border-radius:9px;

    border:1px solid #d9e0ea;

    background:#ffffff;

    color:#344054;

    font-size:13px;

    font-weight:600;

    cursor:pointer;

    margin-top:12px;

}


/* =========================================================
   SUMMARY
========================================================= */

.summary-row{

    display:flex;

    justify-content:space-between;

    align-items:center;

    padding:11px 0;

    border-bottom:1px solid #edf1f5;

}

.summary-row span:first-child{

    color:#667085;

    font-size:13px;

}

.summary-row span:last-child{

    color:#24324a;

    font-size:13px;

    font-weight:700;

}

.summary-total{

    margin-top:14px;

    padding:15px;

    border-radius:11px;

    background:#f0fdf4;

    border:1px solid #bbf7d0;

}

.summary-total span:first-child{

    display:block;

    color:#15803d;

    font-size:12px;

    margin-bottom:4px;

}

.summary-total span:last-child{

    color:#15803d;

    font-size:20px;

    font-weight:700;

}


/* =========================================================
   TEXTAREA
========================================================= */

.keterangan-label{

    display:block;

    margin-top:18px;

    margin-bottom:7px;

    font-size:13px;

    font-weight:600;

    color:#344054;

}

.keterangan-input{

    width:100%;

    min-height:105px;

    border:1px solid #d9e0ea;

    border-radius:10px;

    padding:12px;

    resize:vertical;

    font-size:13px;

    outline:none;

}

.keterangan-input:focus{

    border-color:#355cc9;

    box-shadow:0 0 0 3px rgba(53,92,201,.10);

}


/* =========================================================
   BUTTON SIMPAN
========================================================= */

.btn-simpan-retur{

    width:100%;

    height:45px;

    margin-top:15px;

    border:none;

    border-radius:10px;

    background:#355cc9;

    color:#ffffff;

    font-size:14px;

    font-weight:700;

    cursor:pointer;

    transition:.2s;

}

.btn-simpan-retur:hover{

    background:#2748a8;

}

.btn-simpan-retur:disabled{

    opacity:.6;

    cursor:not-allowed;

}


/* =========================================================
   DAFTAR TRANSAKSI
========================================================= */

.transaction-result{

    margin-top:18px;

}


/* =========================================================
   INFORMATION NOTE
========================================================= */

.return-note{

    display:flex;

    gap:10px;

    padding:13px;

    margin-top:15px;

    border-radius:10px;

    background:#fff8e7;

    border:1px solid #fde68a;

    color:#92400e;

    font-size:12px;

    line-height:1.5;

}

/* ==========================================================
   TOMBOL MUAT LEBIH BANYAK
========================================================== */

.load-more-wrapper{

    display:flex;

    justify-content:flex-start;

    align-items:center;

    margin-top:14px;

}

.btn-load-more{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:7px;

    padding:8px 14px;

    border:1px solid #355cc9;

    border-radius:8px;

    background:#ffffff;

    color:#355cc9;

    font-size:12px;

    font-weight:600;

    cursor:pointer;

    transition:all .2s ease;

}

.btn-load-more i{

    font-size:11px;

}

.btn-load-more:hover{

    background:#355cc9;

    color:#ffffff;

    border-color:#355cc9;

    box-shadow:0 4px 10px rgba(53,92,201,.15);

}

.btn-load-more:active{

    transform:scale(.98);

}

.btn-load-more:disabled{

    opacity:.65;

    cursor:not-allowed;

    transform:none;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1100px){

    .retur-layout{

        grid-template-columns:1fr;

    }

}

@media(max-width:768px){

    .retur-header{

        flex-direction:column;

        gap:15px;

    }

    .jenis-retur-grid{

        grid-template-columns:1fr;

    }

    .return-step-line{

        width:40px;

        margin:0 8px;

    }

}

@media(max-width:576px){

    .retur-card{

        padding:16px;

    }

    .retur-header h1{

        font-size:25px;

    }

    .return-step{

        font-size:11px;

    }

    .return-step-number{

        width:26px;

        height:26px;

    }

}

/* ===========================================================
   TOMBOL PILIH TRANSAKSI
=========================================================== */

.btn-pilih {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 8px 16px;

    background: #355cc9;

    color: #ffffff;

    border: none;

    border-radius: 8px;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.2s ease;

}

.btn-pilih:hover {

    background: #2748a8;

    transform: translateY(-1px);

}

.btn-pilih:active {

    transform: translateY(0);

}

/* ==========================================================
   TOMBOL LIHAT DETAIL PENJUALAN
========================================================== */

.btn-sale-detail{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:9px;

    width:100%;

    box-sizing:border-box;

    padding:11px 16px;

    margin-top:16px;

    border:1px solid #d9e2f3;

    border-radius:10px;

    background:#ffffff;

    color:#355cc9;

    text-decoration:none;

    font-size:14px;

    font-weight:600;

    cursor:pointer;

    transition:all .25s ease;

}

.btn-sale-detail i{

    font-size:14px;

}

.btn-sale-detail:hover{

    background:#355cc9;

    border-color:#355cc9;

    color:#ffffff;

    box-shadow:0 5px 12px rgba(53,92,201,.18);

}

.btn-sale-detail:active{

    transform:scale(.98);

}

</style>

@endsection

@section('title','Retur Barang')

@section('content')

<div class="retur-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="retur-header">

        <div>

            <h1>Retur Transaksi</h1>

            <p>
                Proses retur barang dari transaksi penjualan.
            </p>

        </div>

        <a
            href="{{ route('kasir.dashboard') }}"
            class="btn-kembali">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>


    {{-- =====================================================
         STEPPER
    ====================================================== --}}

    <div class="return-stepper">

        <div class="return-step active">

            <div class="return-step-number">

                1

            </div>

            <span>Pilih Transaksi</span>

        </div>

        <div class="return-step-line"></div>

        <div class="return-step">

            <div class="return-step-number">

                2

            </div>

            <span>Proses Retur</span>

        </div>

        <div class="return-step-line"></div>

        <div class="return-step">

            <div class="return-step-number">

                3

            </div>

            <span>Selesai</span>

        </div>

    </div>


    {{-- =====================================================
         GRID UTAMA
    ====================================================== --}}

    <div class="retur-layout">


        {{-- =================================================
             KOLOM KIRI
        ================================================== --}}

        <div>


            {{-- =============================================
                 CARI TRANSAKSI
            ============================================== --}}

            <div class="retur-card">

                <h3 class="retur-card-title">

                    Pilih Transaksi Penjualan

                </h3>

                <div class="row g-3">

                    <div class="col-md-7">

                        <label
                            class="retur-label"
                            for="searchTransaction">

                            Cari Kode Transaksi

                        </label>

                        <input
                            id="searchTransaction"
                            type="text"
                            class="retur-input"
                            placeholder="Cari kode transaksi / scan barcode..."
                            autocomplete="off">

                    </div>


                    <div class="col-md-5">

                        <label
                            class="retur-label"
                            for="searchDate">

                            Tanggal Transaksi

                        </label>

                        <input
                            id="searchDate"
                            type="date"
                            class="retur-input">

                    </div>

                </div>


                {{-- HASIL PENCARIAN TRANSAKSI --}}

                <div class="transaction-result">

                    <div class="retur-table-wrapper">

                        <table class="retur-table">

                            <thead>

                                <tr>

                                    <th>Kode</th>

                                    <th>Tanggal</th>

                                    <th>Kasir</th>

                                    <th>Total</th>

                                    <th>Aksi</th>

                                </tr>

                            </thead>

                            <tbody id="transactionTable">

                                <tr>

                                    <td
                                        colspan="5"
                                        style="text-align:center;">

                                        Memuat data transaksi...

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    <div class="load-more-wrapper">

                        <button
                            type="button"
                            id="loadMoreSales"
                            class="btn-load-more">

                            <i class="fa-solid fa-plus"></i>

                            Muat Lebih Banyak

                        </button>

                    </div>

                </div>

            </div>

            {{-- =============================================
                 JENIS RETUR
            ============================================== --}}

            <div class="retur-card">

                <div class="jenis-retur-title">

                    Jenis Retur

                </div>


                <div class="jenis-retur-grid">


                    {{-- RETUR UANG --}}

                    <div
                        class="jenis-retur-card"
                            id="jenisReturUang">

                        <div class="jenis-retur-check">

                            <i class="fa-solid fa-check"></i>

                        </div>

                        <div class="jenis-retur-icon">

                            <i class="fa-solid fa-money-bill-transfer"></i>

                        </div>

                        <h4>

                            Retur Uang

                        </h4>

                        <p>

                            Barang dikembalikan dan uang
                            akan dikembalikan kepada pelanggan.

                        </p>

                    </div>


                    {{-- TUKAR BARANG --}}

                    <div
                        class="jenis-retur-card exchange"
                        id="jenisTukarBarang">

                        <div class="jenis-retur-check">

                            <i class="fa-solid fa-check"></i>

                        </div>

                        <div class="jenis-retur-icon">

                            <i class="fa-solid fa-box-open"></i>

                        </div>

                        <h4>

                            Tukar Barang

                        </h4>

                        <p>

                            Barang dikembalikan dan pelanggan
                            memilih barang pengganti.

                        </p>

                    </div>

                </div>

            </div>


            {{-- =============================================
                 DETAIL BARANG
            ============================================== --}}

            <div class="retur-card">

                <h3 class="retur-card-title">

                    Barang yang Dikembalikan

                </h3>

                <div class="retur-card-subtitle">

                    Pilih barang dari transaksi dan tentukan
                    jumlah yang akan diretur.

                </div>


                <div class="retur-table-wrapper">

                    <table class="retur-table retur-detail-table">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Produk</th>

                                <th>Harga</th>

                                <th>Qty Dibeli</th>

                                <th>Qty Retur</th>

                                <th>Subtotal</th>

                            </tr>

                        </thead>

                        <tbody id="detailBody">

                            <tr>

                                <td
                                    colspan="6"
                                    style="text-align:center; padding:35px;">

                                    <div style="
                                        color:#98a2b3;
                                        font-size:13px;
                                    ">

                                        <i
                                            class="fa-solid fa-box-open"
                                            style="
                                                font-size:25px;
                                                display:block;
                                                margin-bottom:8px;
                                            "></i>

                                        Pilih transaksi penjualan terlebih dahulu.

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <div class="return-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>

                        Qty retur tidak boleh melebihi jumlah
                        barang yang dibeli.

                    </span>

                </div>

            </div>

            {{-- =============================================
                TUKAR BARANG
            ============================================= --}}

            <div
                class="retur-card"
                id="exchangeSection"
                style="display:none;">

                <h3 class="retur-card-title">

                    Barang Pengganti

                </h3>

                <div class="retur-card-subtitle">

                    Pilih barang pengganti dengan nilai
                    sama atau lebih besar dari nilai barang yang diretur.

                </div>


                {{-- SEARCH PRODUK --}}

                <div class="exchange-search-wrapper">

                    <input
                        type="text"
                        id="exchangeProductSearch"
                        class="exchange-search-input"
                        placeholder="Cari produk pengganti..."
                        autocomplete="off">

                    <div
                        id="exchangeProductResult"
                        class="exchange-product-result">
                    </div>

                </div>


                {{-- TABEL BARANG PENGGANTI --}}

                <div class="retur-table-wrapper">

                    <table class="retur-table retur-detail-table">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Produk</th>

                                <th>Harga</th>

                                <th>Stok</th>

                                <th>Qty</th>

                                <th>Subtotal</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody id="exchangeBody">

                            <tr>

                                <td
                                    colspan="7"
                                    class="exchange-empty">

                                    <i class="fa-solid fa-box-open"></i>

                                    <div>
                                        Belum ada barang pengganti
                                    </div>

                                    <small>
                                        Cari dan pilih produk pengganti di atas.
                                    </small>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                {{-- CATATAN --}}

                <div class="exchange-note">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>
                        Nilai barang pengganti harus sama atau
                        lebih besar dari nilai retur.
                    </span>

                </div>

            </div>

            {{-- =============================================
                 KETERANGAN
            ============================================== --}}

            <div class="retur-card">

                <label
                    for="keteranganRetur"
                    class="keterangan-label">

                    Keterangan Retur

                </label>

                <textarea
                    id="keteranganRetur"
                    class="keterangan-input"
                    rows="5"
                    placeholder="Contoh: Barang rusak, kemasan sobek, barang tidak sesuai pesanan..."></textarea>

            </div>


        </div>


        {{-- =================================================
             KOLOM KANAN
        ================================================== --}}

        <div>


            {{-- =============================================
                 INFORMASI PENJUALAN
            ============================================== --}}

            <div class="retur-card">

                <h3 class="retur-card-title">

                    Informasi Penjualan Asli

                </h3>

                <div class="info-list">

                    <div class="info-row">

                        <span>Kode Penjualan</span>

                        <span id="saleKode">

                            -

                        </span>

                    </div>

                    <div class="info-row">

                        <span>Tanggal</span>

                        <span id="saleTanggal">

                            -

                        </span>

                    </div>

                    <div class="info-row">

                        <span>Kasir</span>

                        <span id="saleKasir">

                            -

                        </span>

                    </div>

                    <div class="info-row">

                        <span>Total Penjualan</span>

                        <span id="saleTotal">

                            Rp 0

                        </span>

                    </div>

                    <div class="info-row" id="exchangeDeadlineRow">

                        <span>Batas Penukaran</span>

                        <strong id="exchangeDeadline">-</strong>

                    </div>

                </div>


                <a href="#"
                    id="saleDetailLink"
                    class="btn-sale-detail">

                    <i class="fa-solid fa-eye"></i>

                    <span>Lihat Detail Penjualan</span>

                </a>

            </div>


            {{-- =============================================
                 RINGKASAN RETUR
            ============================================== --}}

            <div class="retur-card">

                <h3 class="retur-card-title">

                    Ringkasan Retur

                </h3>


                <div class="summary-row">

                    <span>

                        Total Item

                    </span>

                    <span id="summaryItem">

                        0

                    </span>

                </div>


                <div class="summary-row">

                    <span>

                        Total Qty Retur

                    </span>

                    <span id="summaryQty">

                        0

                    </span>

                </div>


                <div class="summary-row">

                    <span>

                        Total Nilai Retur

                    </span>

                    <span id="summaryNilai">

                        Rp 0

                    </span>

                </div>


                {{-- =============================================
                    RINGKASAN TUKAR BARANG
                ============================================= --}}

                <div
                    id="exchangeSummary"
                    style="display: none;">

                    <div class="summary-row">

                        <span>

                            Total Nilai Pengganti

                        </span>

                        <span id="summaryPengganti">

                            Rp 0

                        </span>

                    </div>

                    <div class="summary-total">

                        <span>

                            Selisih yang Harus Dibayar

                        </span>

                        <span id="summarySelisih">

                            Rp 0

                        </span>

                    </div>

                </div>


                <div class="summary-total">

                    <span>

                        Nilai Barang yang Dikembalikan

                    </span>

                    <span id="totalRetur">

                        Rp 0

                    </span>

                </div>


                <button
                    type="button"
                    id="btnSimpanRetur"
                    class="btn-simpan-retur">

                    <i class="fa-solid fa-check-circle"></i>

                    &nbsp;

                    Simpan Retur

                </button>

            </div>


            {{-- =============================================
                 ATURAN RETUR
            ============================================== --}}

            <div class="retur-card">

                <h3 class="retur-card-title">

                    Aturan Retur

                </h3>

                <div style="
                    font-size:13px;
                    color:#667085;
                    line-height:1.8;
                ">

                    <div>

                        ✓ Barang yang diretur harus berasal
                        dari transaksi yang dipilih.

                    </div>

                    <div>

                        ✓ Qty retur tidak boleh melebihi
                        Qty pembelian.

                    </div>

                    <div>

                        ✓ Untuk tukar barang, nilai barang
                        pengganti tidak boleh lebih rendah
                        dari nilai retur.

                    </div>

                </div>

            </div>


        </div>

    </div>

</div>

@endsection

@section('scripts')

<script>

let selectedSaleId = null;

console.log("SCRIPT RETUR DIMUAT");

let selectedSale = null;

let returnItems = [];

let totalRetur = 0;

/*
|--------------------------------------------------------------------------
| DATA TUKAR BARANG
|--------------------------------------------------------------------------
*/

const exchangeProducts = @json($products);

let exchangeItems = [];

let returnType = "uang";

let transactionOffset = 0;

const transactionLimit = 10;

let hasMoreTransaction = true;

let isLoadingTransaction = false;

async function loadTransaction(id){

    console.log("klik", id);

    selectedSaleId = id;

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

        renderSaleInfo();

        /*
        |--------------------------------------------------------------------------
        | HITUNG BATAS PENUKARAN 7 HARI
        |--------------------------------------------------------------------------
        */

        const exchangeDeadline =
            getExchangeDeadline(selectedSale.tanggal);

        document.getElementById("exchangeDeadline").textContent =
            formatDateIndonesia(exchangeDeadline);

        updateReturnTypeAvailability();

        returnItems = [];

        renderDetailTable();

    }

    catch(error){

        console.error(error);

    }

}

function renderSaleInfo(){

    if(!selectedSale){

        return;

    }

    document.getElementById("saleKode").textContent =
        selectedSale.kode_penjualan ?? "-";

    document.getElementById("saleTanggal").textContent =
        formatDate(selectedSale.tanggal);

    document.getElementById("saleKasir").textContent =
        selectedSale.user?.name ?? "-";

    document.getElementById("saleTotal").textContent =
        "Rp " +
        Number(selectedSale.total_bayar || 0)
            .toLocaleString("id-ID");


    /*
    |--------------------------------------------------------------------------
    | LINK DETAIL PENJUALAN
    |--------------------------------------------------------------------------
    */

    document.getElementById("saleDetailLink").href =
        "/kasir/riwayat-transaksi/penjualan/" + selectedSaleId;

}

function renderDetailTable(){

    const tbody = document.getElementById("detailBody");

    tbody.innerHTML = "";

    returnItems = [];

    /*
    |--------------------------------------------------------------------------
    | Ambil detail barang dari transaksi
    |--------------------------------------------------------------------------
    */

    const saleDetails =
        selectedSale.sale_details ||
        selectedSale.saleDetails ||
        [];

    /*
    |--------------------------------------------------------------------------
    | Jika detail barang tidak ditemukan
    |--------------------------------------------------------------------------
    */

    if(saleDetails.length === 0){

        tbody.innerHTML = `

            <tr>

                <td
                    colspan="6"
                    style="
                        text-align:center;
                        padding:35px;
                        color:#98a2b3;
                    ">

                    <i
                        class="fa-solid fa-box-open"
                        style="
                            font-size:25px;
                            display:block;
                            margin-bottom:8px;
                        ">
                    </i>

                    Detail barang transaksi tidak ditemukan.

                </td>

            </tr>

        `;

        return;

    }

    /*
    |--------------------------------------------------------------------------
    | Tampilkan barang transaksi
    |--------------------------------------------------------------------------
    */

    saleDetails.forEach(function(item, index){

        returnItems.push({

            sale_detail_id: item.id,

            product_id: item.product_id,

            qty_beli: item.qty,

            qty_retur: 0,

            harga: Number(item.harga),

            subtotal: 0

        });

        tbody.innerHTML += `

            <tr>

                <td>
                    ${index + 1}
                </td>

                <td>
                    ${item.product?.nama_produk ?? "-"}
                </td>

                <td>
                    Rp ${Number(item.harga).toLocaleString("id-ID")}
                </td>

                <td>
                    ${item.qty}
                </td>

                <td>

                    <input
                        type="number"
                        class="qty-input"
                        min="0"
                        max="${item.qty}"
                        value="0"
                        onclick="this.select()"
                        oninput="updateQty(${index}, this)"
                    >

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

    let totalItem = 0;
    let totalQty = 0;
    let totalNilai = 0;

    returnItems.forEach(function(item){

        if(item.qty_retur > 0){

            totalItem++;

        }

        totalQty += Number(item.qty_retur);

        totalNilai += Number(item.subtotal);

    });


    /*
    |----------------------------------------------------------
    | TOTAL ITEM
    |----------------------------------------------------------
    */

    document.getElementById("summaryItem").textContent =
        totalItem;


    /*
    |----------------------------------------------------------
    | TOTAL QTY RETUR
    |----------------------------------------------------------
    */

    document.getElementById("summaryQty").textContent =
        totalQty;


    /*
    |----------------------------------------------------------
    | TOTAL NILAI RETUR
    |----------------------------------------------------------
    */

    document.getElementById("summaryNilai").textContent =
        "Rp " + totalNilai.toLocaleString("id-ID");


    /*
    |----------------------------------------------------------
    | UANG YANG DIKEMBALIKAN
    |----------------------------------------------------------
    */

    document.getElementById("totalRetur").textContent =
        "Rp " + totalNilai.toLocaleString("id-ID");

    if(returnType === "tukar"){

        updateExchangeSummary();

    }

}

function prepareReturnPayload() {

    /*
    |--------------------------------------------------------------------------
    | BARANG YANG DIRETUR
    |--------------------------------------------------------------------------
    */

    const items = returnItems

        .filter(item => item.qty_retur > 0)

        .map(item => ({

            sale_detail_id: item.sale_detail_id,

            qty: Number(item.qty_retur)

        }));


    /*
    |--------------------------------------------------------------------------
    | DATA BARANG PENGGANTI
    |--------------------------------------------------------------------------
    */

    const exchange_items = exchangeItems.map(item => ({

        product_id: item.product_id,

        qty: Number(item.qty),

        harga: Number(item.harga)

    }));


    /*
    |--------------------------------------------------------------------------
    | AMBIL RINGKASAN TUKAR BARANG
    |--------------------------------------------------------------------------
    */

    const summary = window.exchangeSummary || {

        nilaiRetur: 0,

        nilaiPengganti: 0,

        selisih: 0

    };


    /*
    |--------------------------------------------------------------------------
    | PAYLOAD
    |--------------------------------------------------------------------------
    */

    return {

        sale_id: selectedSale.id,

        return_type: returnType,

        items: items,

        exchange_items:
            returnType === "tukar"
                ? exchange_items
                : [],

        total_retur:
            Number(summary.nilaiRetur),

        total_pengganti:
            returnType === "tukar"
                ? Number(summary.nilaiPengganti)
                : 0,

        selisih_bayar:
            returnType === "tukar"
                ? Number(summary.selisih)
                : 0,

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

    const payload =
        prepareReturnPayload();

    console.log(
        "PAYLOAD RETUR:",
        payload
    );

    const btnSimpan =
        document.getElementById("btnSimpanRetur");


    try {

        /*
        |--------------------------------------------------------------------------
        | Ubah tombol menjadi loading
        |--------------------------------------------------------------------------
        */

        btnSimpan.disabled = true;

        btnSimpan.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Menyimpan...
        `;


        /*
        |--------------------------------------------------------------------------
        | Kirim data ke backend
        |--------------------------------------------------------------------------
        */

        const response = await fetch("/kasir/retur", {

            method: "POST",

            headers: {

                "Content-Type": "application/json",

                "Accept": "application/json",

                "X-CSRF-TOKEN":
                    document
                        .querySelector(
                            'meta[name="csrf-token"]'
                        )
                        .getAttribute("content")

            },

            body: JSON.stringify(payload)

        });


        /*
        |--------------------------------------------------------------------------
        | Ambil response JSON
        |--------------------------------------------------------------------------
        */

        let result;

        try {

            result = await response.json();

        } catch (jsonError) {

            throw new Error(
                "Server memberikan response yang tidak valid."
            );

        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSE GAGAL
        |--------------------------------------------------------------------------
        */

        if (!response.ok) {

            throw new Error(

                result.message ||
                "Retur gagal disimpan."

            );

        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSE BERHASIL
        |--------------------------------------------------------------------------
        */

        if (result.success) {

            alert(
                result.message ||
                "Retur berhasil disimpan."
            );


            /*
            |--------------------------------------------------------------------------
            | Reload halaman setelah berhasil
            |--------------------------------------------------------------------------
            */

            setTimeout(function () {

                window.location.reload();

            }, 300);


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Backend mengembalikan success = false
        |--------------------------------------------------------------------------
        */

        throw new Error(

            result.message ||
            "Retur gagal disimpan."

        );

    }


    catch (error) {

        console.error(
            "Gagal menyimpan retur:",
            error
        );


        /*
        |--------------------------------------------------------------------------
        | Tampilkan pesan dari backend
        |--------------------------------------------------------------------------
        */

        alert(
            error.message ||
            "Terjadi kesalahan saat menyimpan retur."
        );


        /*
        |--------------------------------------------------------------------------
        | Kembalikan tombol ke kondisi normal
        |--------------------------------------------------------------------------
        */

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

document
    .getElementById("btnSimpanRetur")
    .addEventListener("click", function () {

        /*
        |--------------------------------------------------------------------------
        | CEK TRANSAKSI
        |--------------------------------------------------------------------------
        */

        if (!selectedSale) {

            alert(
                "Silakan pilih transaksi terlebih dahulu."
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | CEK BATAS RETUR 7 HARI
        |--------------------------------------------------------------------------
        */

        if (!isReturnAllowed(selectedSale.tanggal)) {

            const deadline =
                getExchangeDeadline(selectedSale.tanggal);

            alert(
                "Transaksi ini sudah melewati batas waktu retur 7 hari.\n\n" +

                "Batas retur: " +

                formatDateIndonesia(deadline) +

                "\n\n" +

                "Retur uang maupun tukar barang tidak dapat dilakukan."
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | SIAPKAN PAYLOAD
        |--------------------------------------------------------------------------
        */

        const payload =
            prepareReturnPayload();


        /*
        |--------------------------------------------------------------------------
        | MINIMAL SATU BARANG DIRETUR
        |--------------------------------------------------------------------------
        */

        if (payload.items.length === 0) {

            alert(
                "Silakan masukkan Qty Retur minimal 1."
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI TUKAR BARANG
        |--------------------------------------------------------------------------
        */

        if (returnType === "tukar") {

            const summary =
                window.exchangeSummary || {

                    nilaiRetur: 0,

                    nilaiPengganti: 0,

                    selisih: 0

                };


            /*
            |--------------------------------------------------------------------------
            | HARUS ADA BARANG PENGGANTI
            |--------------------------------------------------------------------------
            */

            if (exchangeItems.length === 0) {

                alert(
                    "Silakan pilih minimal satu barang pengganti."
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | NILAI PENGGANTI TIDAK BOLEH LEBIH RENDAH
            |--------------------------------------------------------------------------
            */

            if (
                summary.nilaiPengganti <
                summary.nilaiRetur
            ) {

                alert(

                    "Retur tidak dapat disimpan.\n\n" +

                    "Nilai barang pengganti (Rp " +

                    summary.nilaiPengganti
                        .toLocaleString("id-ID") +

                    ") tidak boleh lebih rendah " +

                    "dari nilai barang yang diretur (Rp " +

                    summary.nilaiRetur
                        .toLocaleString("id-ID") +

                    ")."

                );

                return;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | KONFIRMASI
        |--------------------------------------------------------------------------
        */

        if (
            !confirm(
                "Apakah Anda yakin ingin menyimpan retur ini?"
            )
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | KIRIM KE BACKEND
        |--------------------------------------------------------------------------
        */

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

    const button = document.getElementById("loadMoreSales");

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

function formatDate(dateString){

    if(!dateString){

        return "-";

    }

    const date = new Date(dateString);

    const day =
        String(date.getDate()).padStart(2, "0");

    const month =
        String(date.getMonth() + 1).padStart(2, "0");

    const year =
        date.getFullYear();

    return `${day}/${month}/${year}`;

}

function buildTransactionRow(sale){

    return `

    <tr>

        <td>

            ${sale.kode_penjualan}

        </td>

        <td>

            ${formatDate(sale.tanggal)}

        </td>

        <td>

            ${sale.user.name}

        </td>

        <td>

            Rp ${Number(sale.total_bayar).toLocaleString("id-ID")}

        </td>

        <td>

            <button
                type="button"
                class="btn-pilih"
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
            "loadMoreSales"
        );

    if(!button){

        return;

    }

    button.style.display =
        hasMoreTransaction
            ? "inline-flex"
            : "none";

}

document
    .getElementById("loadMoreSales")
    .addEventListener("click", function(){

        loadMoreTransactions();

    });

document.addEventListener("DOMContentLoaded", function(){

    searchTransaction();

});

/*
|--------------------------------------------------------------------------
| PILIH JENIS RETUR
|--------------------------------------------------------------------------
*/

document
    .getElementById("jenisReturUang")
    .addEventListener("click", function(){

        if(this.classList.contains("disabled")){

            const deadline =
                getExchangeDeadline(selectedSale?.tanggal);

            alert(
                "Retur sudah melewati batas waktu 7 hari.\n\n" +
                "Batas retur: " +
                formatDateIndonesia(deadline) +
                "\n\n" +
                "Retur uang maupun tukar barang tidak dapat dilakukan."
            );

            return;

        }

        /*
        |--------------------------------------------------------------------------
        | CEK TRANSAKSI
        |--------------------------------------------------------------------------
        */

        if(!selectedSale){

            alert("Silakan pilih transaksi terlebih dahulu.");

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | CEK BATAS RETUR 7 HARI
        |--------------------------------------------------------------------------
        */

        if(!isReturnAllowed(selectedSale.tanggal)){

            const deadline =
                getExchangeDeadline(selectedSale.tanggal);

            alert(
                "Retur uang sudah melewati batas waktu 7 hari.\n\n" +
                "Batas retur: " +
                formatDateIndonesia(deadline)
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | JIKA MASIH DALAM BATAS WAKTU
        |--------------------------------------------------------------------------
        */

        returnType = "uang";

        this.classList.add("active");

        document
            .getElementById("jenisTukarBarang")
            .classList.remove("active");

        document
            .getElementById("exchangeSection")
            .style.display = "none";

        exchangeItems = [];

        renderExchangeTable();

        updateExchangeSummary();

});

document
    .getElementById("jenisTukarBarang")
    .addEventListener("click", function(){

        if(this.classList.contains("disabled")){

            const deadline =
                getExchangeDeadline(selectedSale?.tanggal);

            alert(
                "Retur sudah melewati batas waktu 7 hari.\n\n" +
                "Batas retur: " +
                formatDateIndonesia(deadline) +
                "\n\n" +
                "Retur uang maupun tukar barang tidak dapat dilakukan."
            );

            return;

        }

        /*
        |--------------------------------------------------------------------------
        | CEK TRANSAKSI
        |--------------------------------------------------------------------------
        */

        if(!selectedSale){

            alert("Silakan pilih transaksi terlebih dahulu.");

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | CEK BATAS PENUKARAN 7 HARI
        |--------------------------------------------------------------------------
        */

        if(!isReturnAllowed(selectedSale.tanggal)){

            const deadline =
                getExchangeDeadline(selectedSale.tanggal);

            alert(
                "Retur barang sudah melewati batas waktu 7 hari.\n\n" +
                "Batas retur: " +
                formatDateIndonesia(deadline)
            );

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | JIKA MASIH DALAM BATAS WAKTU
        |--------------------------------------------------------------------------
        */

        returnType = "tukar";

        this.classList.add("active");

        document
            .getElementById("jenisReturUang")
            .classList.remove("active");

        document
            .getElementById("exchangeSection")
            .style.display = "block";

        renderExchangeTable();

        updateExchangeSummary();

});

/*
|--------------------------------------------------------------------------
| SEARCH PRODUK PENGGANTI
|--------------------------------------------------------------------------
*/

const exchangeSearch =
    document.getElementById("exchangeProductSearch");

const exchangeResult =
    document.getElementById("exchangeProductResult");


exchangeSearch.addEventListener("input", function(){

    const keyword =
        this.value.toLowerCase().trim();

    if(keyword === ""){

        exchangeResult.style.display = "none";

        return;

    }

    const results =
        exchangeProducts
            .filter(product =>
                product.nama_produk
                    .toLowerCase()
                    .includes(keyword)
            )
            .slice(0, 10);


    if(results.length === 0){

        exchangeResult.innerHTML = `

            <div class="exchange-product-item">

                <strong>
                    Produk tidak ditemukan
                </strong>

            </div>

        `;

        exchangeResult.style.display = "block";

        return;

    }


    let html = "";

    results.forEach(function(product){

        html += `

            <div
                class="exchange-product-item"
                onclick="addExchangeProduct(${product.id})">

                <strong>
                    ${product.nama_produk}
                </strong>

                <small>
                    Rp ${Number(product.harga_jual)
                        .toLocaleString("id-ID")}
                    • Stok ${product.stok}
                </small>

            </div>

        `;

    });


    exchangeResult.innerHTML = html;

    exchangeResult.style.display = "block";

});

/*
|--------------------------------------------------------------------------
| TAMBAH BARANG PENGGANTI
|--------------------------------------------------------------------------
*/

function addExchangeProduct(id){

    const product =
        exchangeProducts.find(
            item => item.id == id
        );

    if(!product){

        return;

    }


    const existing =
        exchangeItems.find(
            item => item.product_id == id
        );


    if(existing){

        if(existing.qty >= product.stok){

            alert(
                "Qty tidak boleh melebihi stok tersedia."
            );

            return;

        }

        existing.qty++;

    }else{

        exchangeItems.push({

            product_id: product.id,

            nama: product.nama_produk,

            harga: Number(product.harga_jual),

            stok: Number(product.stok),

            qty: 1

        });

    }


    exchangeSearch.value = "";

    exchangeResult.style.display = "none";

    renderExchangeTable();

    updateExchangeSummary();

}

/*
|--------------------------------------------------------------------------
| RENDER BARANG PENGGANTI
|--------------------------------------------------------------------------
*/

function renderExchangeTable(){

    const tbody =
        document.getElementById("exchangeBody");


    if(exchangeItems.length === 0){

        tbody.innerHTML = `

            <tr>

                <td
                    colspan="7"
                    class="exchange-empty">

                    <i class="fa-solid fa-box-open"></i>

                    <div>
                        Belum ada barang pengganti
                    </div>

                    <small>
                        Cari dan pilih produk pengganti di atas.
                    </small>

                </td>

            </tr>

        `;

        return;

    }


    let html = "";


    exchangeItems.forEach(function(item, index){

        const subtotal =
            item.qty * item.harga;


        html += `

            <tr>

                <td>
                    ${index + 1}
                </td>

                <td>
                    ${item.nama}
                </td>

                <td>
                    Rp ${item.harga
                        .toLocaleString("id-ID")}
                </td>

                <td>
                    ${item.stok}
                </td>

                <td>

                    <input
                        type="number"
                        class="exchange-qty-input"
                        min="1"
                        max="${item.stok}"
                        value="${item.qty}"
                        onclick="this.select()"
                        oninput="updateExchangeQty(
                            ${index},
                            this
                        )">

                </td>

                <td>
                    Rp ${subtotal
                        .toLocaleString("id-ID")}
                </td>

                <td>

                    <button
                        type="button"
                        class="exchange-delete"
                        onclick="removeExchangeProduct(${index})">

                        <i class="fa-solid fa-trash"></i>

                    </button>

                </td>

            </tr>

        `;

    });


    tbody.innerHTML = html;

}

/*
|--------------------------------------------------------------------------
| UPDATE QTY BARANG PENGGANTI
|--------------------------------------------------------------------------
*/

function updateExchangeQty(index, input){

    let value =
        parseInt(input.value);


    if(isNaN(value) || value < 1){

        value = 1;

    }


    const item =
        exchangeItems[index];


    if(value > item.stok){

        alert(
            "Qty tidak boleh melebihi stok tersedia."
        );

        value = item.stok;

    }


    item.qty = value;

    input.value = value;

    renderExchangeTable();

    updateExchangeSummary();

}

/*
|--------------------------------------------------------------------------
| HAPUS BARANG PENGGANTI
|--------------------------------------------------------------------------
*/

function removeExchangeProduct(index){

    exchangeItems.splice(index, 1);

    renderExchangeTable();

    updateExchangeSummary();

}

/*
|--------------------------------------------------------------------------
| HITUNG NILAI TUKAR BARANG
|--------------------------------------------------------------------------
*/

function updateExchangeSummary(){

    let nilaiRetur = 0;

    let nilaiPengganti = 0;


    /*
    |--------------------------------------------------------------------------
    | NILAI BARANG YANG DIRETUR
    |--------------------------------------------------------------------------
    */

    returnItems.forEach(function(item){

        nilaiRetur +=
            Number(item.subtotal);

    });


    /*
    |--------------------------------------------------------------------------
    | NILAI BARANG PENGGANTI
    |--------------------------------------------------------------------------
    */

    exchangeItems.forEach(function(item){

        nilaiPengganti +=
            Number(item.qty) *
            Number(item.harga);

    });


    /*
    |--------------------------------------------------------------------------
    | HITUNG SELISIH
    |--------------------------------------------------------------------------
    */

    const selisih =
        nilaiPengganti - nilaiRetur;


    /*
    |--------------------------------------------------------------------------
    | SIMPAN KE GLOBAL
    |--------------------------------------------------------------------------
    */

    window.exchangeSummary = {

        nilaiRetur: nilaiRetur,

        nilaiPengganti: nilaiPengganti,

        selisih: selisih

    };


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN RINGKASAN TUKAR BARANG
    |--------------------------------------------------------------------------
    */

    const exchangeSummary =
        document.getElementById("exchangeSummary");


    const summaryPengganti =
        document.getElementById("summaryPengganti");


    const summarySelisih =
        document.getElementById("summarySelisih");


    /*
    |--------------------------------------------------------------------------
    | HANYA TAMPILKAN SAAT TUKAR BARANG
    |--------------------------------------------------------------------------
    */

    if(returnType === "tukar"){

        exchangeSummary.style.display = "block";


        summaryPengganti.textContent =
            "Rp " +
            nilaiPengganti.toLocaleString("id-ID");


        summarySelisih.textContent =
            "Rp " +
            Math.max(selisih, 0)
                .toLocaleString("id-ID");

    }
    else{

        exchangeSummary.style.display = "none";

    }


    /*
    |--------------------------------------------------------------------------
    | DEBUG
    |--------------------------------------------------------------------------
    */

    console.log(
        "Ringkasan Tukar Barang:",
        window.exchangeSummary
    );

}

function getExchangeDeadline(dateString) {

    if (!dateString) {
        return null;
    }

    const date = new Date(dateString + "T00:00:00");

    date.setDate(date.getDate() + 7);

    return date;
}

function formatDateIndonesia(date) {

    if (!date) {
        return "-";
    }

    return date.toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric"
    });

}

function isReturnAllowed(saleDate) {

    if (!saleDate) {
        return false;
    }

    const today = new Date();

    today.setHours(0, 0, 0, 0);

    const deadline = getExchangeDeadline(saleDate);

    if (!deadline) {
        return false;
    }

    deadline.setHours(0, 0, 0, 0);

    return today <= deadline;

}

function updateReturnTypeAvailability(){

    const uangCard =
        document.getElementById("jenisReturUang");

    const tukarCard =
        document.getElementById("jenisTukarBarang");

    /*
    |--------------------------------------------------------------------------
    | Belum ada transaksi
    |--------------------------------------------------------------------------
    */

    if(!selectedSale){

        uangCard.classList.remove("disabled");

        tukarCard.classList.remove("disabled");

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Cek apakah retur masih diperbolehkan
    |--------------------------------------------------------------------------
    */

    const allowed =
        isReturnAllowed(selectedSale.tanggal);


    /*
    |--------------------------------------------------------------------------
    | Transaksi masih dalam 7 hari
    |--------------------------------------------------------------------------
    */

    if(allowed){

        uangCard.classList.remove("disabled");

        tukarCard.classList.remove("disabled");

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Transaksi sudah melewati 7 hari
    |--------------------------------------------------------------------------
    */

    uangCard.classList.add("disabled");

    tukarCard.classList.add("disabled");


    /*
    |--------------------------------------------------------------------------
    | Pastikan tidak ada jenis retur yang tetap aktif
    |--------------------------------------------------------------------------
    */

    uangCard.classList.remove("active");

    tukarCard.classList.remove("active");


    /*
    |--------------------------------------------------------------------------
    | Sembunyikan bagian tukar barang
    |--------------------------------------------------------------------------
    */

    document
        .getElementById("exchangeSection")
        .style.display = "none";


    /*
    |--------------------------------------------------------------------------
    | Reset tipe retur
    |--------------------------------------------------------------------------
    */

    returnType = null;

}

</script>

@endsection