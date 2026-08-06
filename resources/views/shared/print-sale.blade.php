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

.print-receipt{

    width:76mm;

    max-width:76mm;

    margin:auto;

    padding:4mm;

    background:#fff;

    color:#000;

    font-family:"Courier New", monospace;

    font-size:11px;

    line-height:1.4;

}

@media print{

    @page{

        size:80mm auto;

        margin:4mm;

    }


    /* Header */

    .receipt-header{

        text-align:center;

        margin-bottom:5px;

    }

    .receipt-header h2{

        font-size:22px;

        font-weight:700;

        letter-spacing:2px;

        margin-bottom:6px;

    }

    .receipt-header p{

        font-size:11px;

        margin:2px 0;

    }


    /* Garis */

    .receipt-divider{
        border-top:1px dashed #000;
        margin:8px 0;
        height:0;
    }


    /* Judul */

    .receipt-title{

        text-align:center;

        font-size:15px;

        font-weight:700;

        letter-spacing:1px;

        margin:5px 0;

    }


    /* Informasi transaksi */

    .receipt-info{

        margin:6px 0;

    }

    .receipt-info div{

        display:flex;

        justify-content:space-between;

        gap:8px;

        margin:2px 0;

    }

    .receipt-info div span:first-child{

        flex:0 0 78px;

    }

    .receipt-info div span:last-child{

        flex:1;

        text-align:right;

        word-break:break-word;

    }


    /* Barang */

    .receipt-items{

        margin:5px 0;

    }

    .receipt-item{

        margin-bottom:7px;

    }

    .receipt-product{

        font-weight:700;

        font-size:11px;

        margin-bottom:3px;

    }

    .receipt-item-detail{

        display:flex;

        justify-content:space-between;

        gap:10px;

        padding-left:8px;

        font-size:10px;

    }


    /* Ringkasan */

    .receipt-summary div{

        display:flex;

        justify-content:space-between;

        gap:10px;

        margin:3px 0;

    }


    /* Total */

    .receipt-total{

        display:flex;

        justify-content:space-between;

        font-size:15px;

        font-weight:700;

        padding:4px 0;

    }


    /* Footer */

    .receipt-footer{

        text-align:center;

        font-size:10px;

        margin-top:12px;

    }

    .receipt-footer p{

        margin:2px 0;

    }

    .receipt-footer strong{

        display:block;

        margin:3px 0 7px;

        font-size:12px;

    }

}

</style>

</head>

<body>

<div class="print-receipt">

    {{-- Header Toko --}}
    <div class="receipt-header">

        <h2>NAYLA BANGUNAN</h2>

        <p>Toko Bahan Bangunan</p>

        <p>Desa Jernih Jaya, Kec. Gunung Tujuh, Kab. Kerinci, Provinsi Jambi</p>

        <p>Telp. 08xxxxxxxxxx</p>

    </div>

    <div class="receipt-divider">
        
    </div>

    <div class="receipt-title">

        INVOICE PEMBELIAN

    </div>

    <div class="receipt-divider">
        
    </div>


    {{-- Informasi Transaksi --}}
    <div class="receipt-info">

        <div>
            <span>No. Transaksi</span>
            <span>{{ $sale->kode_penjualan }}</span>
        </div>

        <div>
            <span>Tanggal</span>
            <span>
                {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
            </span>
        </div>

        <div>
            <span>Kasir</span>
            <span>{{ $sale->user->name ?? '-' }}</span>
        </div>

    </div>


    <div class="receipt-divider">
        
    </div>


    {{-- Daftar Barang --}}
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


    <div class="receipt-divider">
        
    </div>


    {{-- Ringkasan Pembayaran --}}
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


    <div class="receipt-divider">
        
    </div>


    <div class="receipt-total">

        <span>TOTAL</span>

        <span>
            Rp {{ number_format($sale->total_bayar,0,',','.') }}
        </span>

    </div>


    <div class="receipt-divider">
        
    </div>


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


    <div class="receipt-divider">
        
    </div>


    {{-- Footer --}}
    <div class="receipt-footer">

        <p>PENUKARAN BARANG DIPERBOLEHKAN DALAM WAKTU 7 HARI SETELAH PEMBELIAN</p>

        <p>HARAP BAWA KEMBALI INVOICE INI BILA ADA BARANG YANG RUSAK, TIDAK SESUAI, ATAU INGIN MELAKUKAN PENUKARAN</p>


        <P>☺︎ Terima Kasih ☺︎</P>
        <p>Telah Berbelanja di Nayla Bangunan</p>

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