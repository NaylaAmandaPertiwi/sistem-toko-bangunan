<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Invoice Retur</title>

    <style>

        *{
            box-sizing: border-box;
        }


        /* =====================================================
           UKURAN STRUK THERMAL 58 MM
        ====================================================== */

        html,
        body{

            margin: 0;
            padding: 0;

            width: 58mm;

            background: #ffffff;
            color: #000000;

        }


        .print-receipt{

            width: 58mm;
            max-width: 58mm;

            margin: 0;

            padding: 3mm 2mm;

            background: #ffffff;
            color: #000000;

            /*
             * Arial digunakan agar tulisan lebih jelas
             * ketika dicetak menggunakan printer thermal.
             */
            font-family: Arial, sans-serif;

            font-size: 10px;

            line-height: 1.35;

        }


        /* =====================================================
           HEADER TOKO
        ====================================================== */

        .receipt-header{

            text-align: center;

            margin-bottom: 5px;

        }


        .receipt-header h2{

            margin: 0 0 5px;

            font-size: 18px;

            font-weight: 700;

            letter-spacing: 1px;

        }


        .receipt-header p{

            margin: 2px 0;

            font-size: 9px;

            font-weight: 500;

            line-height: 1.3;

            word-break: break-word;

        }


        /* =====================================================
           GARIS PEMISAH
        ====================================================== */

        .receipt-divider{

            border-top: 1px dashed #000;

            margin: 6px 0;

            height: 0;

        }


        /* =====================================================
           JUDUL
        ====================================================== */

        .receipt-title{

            text-align: center;

            font-size: 12px;

            font-weight: 700;

            letter-spacing: .5px;

            margin: 5px 0;

        }


        /* =====================================================
           INFORMASI RETUR
        ====================================================== */

        .receipt-info{

            margin: 6px 0;

        }


        .receipt-info div{

            display: flex;

            justify-content: space-between;

            gap: 5px;

            margin: 3px 0;

            font-size: 9px;

        }


        .receipt-info div span:first-child{

            flex: 0 0 65px;

            font-weight: 500;

        }


        .receipt-info div span:last-child{

            flex: 1;

            text-align: right;

            word-break: break-word;

            font-weight: 500;

        }


        /* =====================================================
           DAFTAR BARANG
        ====================================================== */

        .receipt-items{

            margin-top: 5px;

        }


        .receipt-item{

            margin-bottom: 7px;

        }


        .receipt-product{

            font-weight: 700;

            font-size: 10px;

            margin-bottom: 3px;

            line-height: 1.3;

            word-break: break-word;

        }


        .receipt-item-detail{

            display: flex;

            justify-content: space-between;

            gap: 5px;

            padding-left: 5px;

            font-size: 9px;

            font-weight: 500;

        }


        /* =====================================================
           JUDUL BAGIAN
        ====================================================== */

        .receipt-section-title{

            font-size: 10px;

            font-weight: 700;

            margin: 7px 0 5px;

        }


        /* =====================================================
           RINGKASAN
        ====================================================== */

        .receipt-summary div{

            display: flex;

            justify-content: space-between;

            gap: 5px;

            margin: 3px 0;

            font-size: 9px;

            font-weight: 500;

        }


        .receipt-summary div span:first-child{

            flex: 1;

        }


        .receipt-summary div span:last-child{

            text-align: right;

            word-break: break-word;

        }


        /* =====================================================
           TOTAL
        ====================================================== */

        .receipt-total{

            display: flex;

            justify-content: space-between;

            gap: 5px;

            font-weight: 700;

            font-size: 13px;

            margin: 5px 0;

        }


        .receipt-total span:last-child{

            text-align: right;

        }


        /* =====================================================
           PEMBAYARAN
        ====================================================== */

        .receipt-payment{

            margin-top: 5px;

        }


        .receipt-payment div{

            display: flex;

            justify-content: space-between;

            gap: 5px;

            margin: 3px 0;

            font-size: 9px;

        }


        .receipt-payment div span:first-child{

            flex: 1;

        }


        .receipt-payment div span:last-child{

            text-align: right;

            word-break: break-word;

        }


        .receipt-payment .important{

            font-weight: 700;

            font-size: 10px;

        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .receipt-footer{

            text-align: center;

            margin-top: 10px;

            font-size: 8px;

            font-weight: 500;

            line-height: 1.35;

        }


        .receipt-footer p{

            margin: 3px 0;

        }


        .receipt-footer strong{

            font-size: 9px;

        }


        /* =====================================================
           PRINT THERMAL 58 MM
        ====================================================== */

        @media print{

            @page{

                size: 58mm auto;

                margin: 0;

            }


            html,
            body{

                width: 58mm;

                margin: 0;

                padding: 0;

            }


            .print-receipt{

                width: 58mm;

                max-width: 58mm;

                margin: 0;

                padding: 3mm 2mm;

                font-family: Arial, sans-serif;

                font-size: 10px;

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

        <p>
            Toko Bahan Bangunan
        </p>

        <p>
            Desa Jernih Jaya, Kec. Gunung Tujuh,
            Kab. Kerinci, Provinsi Jambi
        </p>

        <p>
            Telp. 08xxxxxxxxxx
        </p>

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         JUDUL
    ====================================================== --}}

    <div class="receipt-title">

        INVOICE RETUR

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         INFORMASI RETUR
    ====================================================== --}}

    <div class="receipt-info">

        <div>

            <span>No Retur</span>

            <span>
                {{ $returnSale->kode_retur }}
            </span>

        </div>


        <div>

            <span>No Transaksi</span>

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

            <span>
                {{ $returnSale->user->name }}
            </span>

        </div>


        <div>

            <span>Jenis Retur</span>

            <span>

                @if($returnSale->return_type === 'uang')

                    Retur Uang

                @else

                    Tukar Barang

                @endif

            </span>

        </div>

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         BARANG YANG DIRETUR
    ====================================================== --}}

    <div class="receipt-section-title">

        BARANG DIRETUR

    </div>


    <div class="receipt-items">

        @foreach($returnSale->details as $detail)

            <div class="receipt-item">

                <div class="receipt-product">

                    {{ $detail->product->nama_produk }}

                </div>


                <div class="receipt-item-detail">

                    <span>

                        {{ $detail->qty }}
                        ×
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
         RINGKASAN BARANG RETUR
    ====================================================== --}}

    <div class="receipt-summary">

        <div>

            <span>
                Jumlah Item
            </span>

            <span>
                {{ $returnSale->details->count() }}
            </span>

        </div>


        <div>

            <span>
                Total Qty
            </span>

            <span>
                {{ $returnSale->details->sum('qty') }}
            </span>

        </div>

    </div>


    <div class="receipt-divider"></div>


    {{-- =====================================================
         TOTAL RETUR
    ====================================================== --}}

    <div class="receipt-total">

        <span>
            TOTAL RETUR
        </span>

        <span>

            Rp {{ number_format($returnSale->total_retur,0,',','.') }}

        </span>

    </div>


    {{-- =====================================================
         KHUSUS TUKAR BARANG
    ====================================================== --}}

    @if($returnSale->return_type === 'tukar')

        <div class="receipt-divider"></div>


        <div class="receipt-section-title">

            BARANG PENGGANTI

        </div>


        <div class="receipt-items">

            @foreach($returnSale->exchangeDetails as $exchange)

                <div class="receipt-item">

                    <div class="receipt-product">

                        {{ $exchange->product->nama_produk }}

                    </div>


                    <div class="receipt-item-detail">

                        <span>

                            {{ $exchange->qty }}
                            ×
                            {{ number_format($exchange->harga,0,',','.') }}

                        </span>


                        <span>

                            {{ number_format($exchange->subtotal,0,',','.') }}

                        </span>

                    </div>

                </div>

            @endforeach

        </div>


        <div class="receipt-divider"></div>


        {{-- Nilai barang pengganti --}}

        <div class="receipt-summary">

            <div>

                <span>
                    Nilai Barang Pengganti
                </span>

                <span>

                    Rp {{ number_format($returnSale->total_pengganti,0,',','.') }}

                </span>

            </div>

        </div>


        {{-- =================================================
             STATUS PEMBAYARAN
        ================================================== --}}

        <div class="receipt-divider"></div>


        <div class="receipt-payment">

            @if($returnSale->selisih_bayar > 0)

                <div class="important">

                    <span>
                        SELISIH DIBAYAR
                    </span>

                    <span>

                        Rp {{ number_format($returnSale->selisih_bayar,0,',','.') }}

                    </span>

                </div>


                <div>

                    <span>
                        Status
                    </span>

                    <span>
                        Sudah Dibayar
                    </span>

                </div>

            @else

                <div class="important">

                    <span>
                        PEMBAYARAN
                    </span>

                    <span>
                        Rp 0
                    </span>

                </div>


                <div>

                    <span>
                        Status
                    </span>

                    <span>
                        Tidak Ada Selisih
                    </span>

                </div>

            @endif

        </div>

    @endif


    {{-- =====================================================
         KHUSUS RETUR UANG
    ====================================================== --}}

    @if($returnSale->return_type === 'uang')

        <div class="receipt-divider"></div>


        <div class="receipt-payment">

            <div class="important">

                <span>
                    UANG DIKEMBALIKAN
                </span>

                <span>

                    Rp {{ number_format($returnSale->total_retur,0,',','.') }}

                </span>

            </div>


            <div>

                <span>
                    Status
                </span>

                <span>
                    Sudah Dikembalikan
                </span>

            </div>

        </div>

    @endif


    {{-- =====================================================
         KETERANGAN
    ====================================================== --}}

    @if($returnSale->keterangan)

        <div class="receipt-divider"></div>


        <div class="receipt-summary">

            <div>

                <span>
                    Keterangan
                </span>

                <span>

                    {{ $returnSale->keterangan }}

                </span>

            </div>

        </div>

    @endif


    <div class="receipt-divider"></div>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="receipt-footer">

        <p>
            Retur berhasil diproses.
        </p>

        <p>
            Simpan invoice ini sebagai bukti retur.
        </p>


        <br>


        <strong>
            ☺ Terima Kasih ☺
        </strong>


        <p>
            Telah Berbelanja di Nayla Bangunan
            
        </p>

    </div>


</div>


<script>

window.onload = function(){

    window.print();

};


window.onafterprint = function(){

    window.close();

};

</script>


</body>

</html>