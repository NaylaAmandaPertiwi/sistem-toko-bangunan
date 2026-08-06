<style>

.print-receipt{

    display:none;

}

@media print{

    @page{

        size:80mm auto;

        margin:4mm;

    }


    /* Sembunyikan halaman aplikasi */

    body *{

        visibility:hidden;

    }


    /* Tampilkan hanya struk */

    .print-receipt,
    .print-receipt *{

        visibility:visible;

    }


    .print-receipt{

        display:block;

        position:absolute;

        left:0;

        top:0;

         width:76mm;

        max-width:76mm;

        margin:auto;

        padding:4mm;

        background:#ffffff;

        color:#000000;

        font-family:"Courier New", monospace;

        font-size:11px;

        line-height:1.4;

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

{{-- =========================================================
     STRUK KHUSUS CETAK
========================================================= --}}

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

        INVOICE RETUR

    </div>

    <div class="receipt-divider">
        
    </div>


    {{-- Informasi Transaksi --}}
    <div class="receipt-info">

        <div>

            <span>No. Retur</span>

            <span>

                {{ $returnSale->kode_retur }}

            </span>

        </div>

        <div>

            <span>No. Jual</span>

            <span>

                {{ $returnSale->sale->kode_penjualan }}

            </span>

        </div>

        <div>
            <span>Tanggal</span>
            <span>
                {{ \Carbon\Carbon::parse($returnSale->tanggal)->format('d/m/Y') }}
            </span>
        </div>

        <div>
            <span>Kasir</span>
            <span>{{ $returnSale->user->name }}</span>
        </div>

    </div>


    <div class="receipt-divider">
        
    </div>


    {{-- Daftar Barang --}}
    <div class="receipt-items">

        @foreach($returnSale->details as $detail)

            <div class="receipt-item">

                <div class="receipt-product">

                    {{ $detail->product->nama_produk }}

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

            <span>Jumlah Item Diretur</span>

            <span>
                {{ $returnSale->details->count() }}
            </span>

        </div>

        <div>

            <span>Total Qty Retur</span>

            <span>
                {{ $returnSale->details->sum('qty') }}
            </span>

        </div>

    </div>


    <div class="receipt-divider">
        
    </div>


    <div class="receipt-total">

        <span>

            TOTAL RETUR

        </span>

        <span>

            Rp {{ number_format($returnSale->total_retur,0,',','.') }}

        </span>

    </div>


    <div class="receipt-divider">
        
    </div>


    <div class="receipt-summary">

        <div>

            <span>Nominal Retur</span>

            <span>
                Rp {{ number_format($returnSale->total_retur,0,',','.') }}
            </span>

        </div>

        <div>

            <span>Keterangan</span>

            <span>
                {{ $returnSale->keterangan }}
            </span>

        </div>

    </div>


    <div class="receipt-divider">
        
    </div>


    {{-- Footer --}}
    <div class="receipt-footer">

        <p>Retur berhasil diproses</p>

        <p>Simpan Invoice ini Sebagai Bukti Retur</p>

        <P>☺︎ Terima Kasih ☺︎</P>
        <p>Telah Berbelanja di Nayla Bangunan</p>

    </div>

</div>