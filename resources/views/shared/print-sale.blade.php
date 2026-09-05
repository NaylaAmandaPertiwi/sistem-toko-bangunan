<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        Invoice {{ $sale->kode_penjualan }}
    </title>

<style>

*{
    box-sizing:border-box;
}

html,
body{
    margin:0;
    padding:0;
    width:58mm;
    background:#fff;
}

.print-receipt{

    width:58mm;
    max-width:58mm;

    margin:0;

    /*
     * Jangan terlalu besar karena kertas hanya 58 mm
     */
    padding:3mm 2mm;

    background:#fff;
    color:#000;

    /*
     * Arial biasanya lebih mudah terbaca
     * pada hasil print thermal dari browser
     */
    font-family:Arial, sans-serif;

    font-size:10px;

    line-height:1.35;

}


/* =====================================================
   HEADER
===================================================== */

.receipt-header{

    text-align:center;

    margin-bottom:5px;

}


.receipt-header h2{

    font-size:18px;

    font-weight:700;

    letter-spacing:1px;

    margin:0 0 5px;

}


.receipt-header p{

    font-size:9px;

    font-weight:500;

    margin:2px 0;

    line-height:1.3;

    word-break:break-word;

}


/* =====================================================
   GARIS
===================================================== */

.receipt-divider{

    border-top:1px dashed #000;

    margin:6px 0;

    height:0;

}


/* =====================================================
   JUDUL
===================================================== */

.receipt-title{

    text-align:center;

    font-size:12px;

    font-weight:700;

    letter-spacing:.5px;

    margin:5px 0;

}


/* =====================================================
   INFORMASI TRANSAKSI
===================================================== */

.receipt-info{

    margin:6px 0;

}


.receipt-info div{

    display:flex;

    justify-content:space-between;

    gap:5px;

    margin:3px 0;

    font-size:9px;

}


.receipt-info div span:first-child{

    flex:0 0 65px;

    font-weight:500;

}


.receipt-info div span:last-child{

    flex:1;

    text-align:right;

    word-break:break-word;

    font-weight:500;

}


/* =====================================================
   DAFTAR BARANG
===================================================== */

.receipt-items{

    margin:5px 0;

}


.receipt-item{

    margin-bottom:7px;

}


.receipt-product{

    font-weight:700;

    font-size:10px;

    margin-bottom:3px;

    line-height:1.3;

    word-break:break-word;

}


.receipt-item-detail{

    display:flex;

    justify-content:space-between;

    gap:5px;

    padding-left:5px;

    font-size:9px;

    font-weight:500;

}


/* =====================================================
   RINGKASAN
===================================================== */

.receipt-summary div{

    display:flex;

    justify-content:space-between;

    gap:5px;

    margin:3px 0;

    font-size:9px;

    font-weight:500;

}


/* =====================================================
   TOTAL
===================================================== */

.receipt-total{

    display:flex;

    justify-content:space-between;

    font-size:13px;

    font-weight:700;

    padding:4px 0;

}


/* =====================================================
   FOOTER
===================================================== */

.receipt-footer{

    text-align:center;

    font-size:8px;

    font-weight:500;

    margin-top:10px;

    line-height:1.35;

}


.receipt-footer p{

    margin:3px 0;

}


/* =====================================================
   PRINT THERMAL 58 MM
===================================================== */

@media print{

    @page{

        size:58mm auto;

        margin:0;

    }


    html,
    body{

        width:58mm;

        margin:0;

        padding:0;

    }


    .print-receipt{

        width:58mm;

        max-width:58mm;

        margin:0;

        padding:3mm 2mm;

        font-family:Arial, sans-serif;

        font-size:10px;

    }

}


</style>

</head>

<body>

<div class="print-receipt">

    {{-- =====================================================
         HEADER TOKO
    ====================================================== --}}

    <div class="receipt-header">

        <h2>NAYLA BANGUNAN</h2>

        <p>Toko Bahan Bangunan</p>

        <p>
            Desa Jernih Jaya, Kec. Gunung Tujuh,
            Kab. Kerinci, Provinsi Jambi
        </p>

        <p>Telp. 08xxxxxxxxxx</p>

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         JUDUL
    ====================================================== --}}

    <div class="receipt-title">

        INVOICE PEMBELIAN

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         INFORMASI TRANSAKSI
    ====================================================== --}}

    <div class="receipt-info">

        <div>

            <span>No. Transaksi</span>

            <span>
                {{ $sale->kode_penjualan }}
            </span>

        </div>


        <div>

            <span>Tanggal</span>

            <span>
                {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
            </span>

        </div>


        <div>

            <span>Kasir</span>

            <span>
                {{ $sale->user->name ?? '-' }}
            </span>

        </div>

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         DAFTAR BARANG
    ====================================================== --}}

    <div class="receipt-items">

        @foreach($sale->saleDetails as $detail)

            <div class="receipt-item">

                <div class="receipt-product">

                    {{ $detail->product->nama_produk ?? '-' }}

                </div>


                <div class="receipt-item-detail">

                    <span>

                        {{ $detail->qty }}
                        x
                        {{ number_format($detail->harga,0,',','.') }}

                    </span>


                    <span>

                        {{ number_format($detail->subtotal,0,',','.') }}

                    </span>

                </div>

            </div>

        @endforeach

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         RINGKASAN PEMBAYARAN
    ====================================================== --}}

    <div class="receipt-summary">

        <div>

            <span>Subtotal</span>

            <span>

                Rp {{ number_format($sale->subtotal,0,',','.') }}

            </span>

        </div>


        <div>

            <span>Diskon</span>

            <span>

                Rp {{ number_format($sale->diskon,0,',','.') }}

            </span>

        </div>

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         TOTAL
    ====================================================== --}}

    <div class="receipt-total">

        <span>TOTAL</span>

        <span>

            Rp {{ number_format($sale->total_bayar,0,',','.') }}

        </span>

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         PEMBAYARAN
    ====================================================== --}}

    <div class="receipt-summary">

        <div>

            <span>Bayar</span>

            <span>

                Rp {{ number_format($sale->bayar,0,',','.') }}

            </span>

        </div>


        <div>

            <span>Kembalian</span>

            <span>

                Rp {{ number_format($sale->kembalian,0,',','.') }}

            </span>

        </div>

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="receipt-footer">

        <p>
            PENUKARAN BARANG DIPERBOLEHKAN DALAM WAKTU
            7 HARI SETELAH PEMBELIAN
        </p>

        <p>
            HARAP BAWA KEMBALI INVOICE INI BILA ADA
            BARANG YANG RUSAK, TIDAK SESUAI, ATAU INGIN
            MELAKUKAN PENUKARAN
        </p>

        <p>☺︎ Terima Kasih ☺︎</p>

        <p>
            Telah Berbelanja di Nayla Bangunan
            
        </p>

    </div>

</div>


<script>

window.onload=function(){

    window.print();

};


window.onafterprint=function(){

    window.close();

};

</script>

</body>

</html>