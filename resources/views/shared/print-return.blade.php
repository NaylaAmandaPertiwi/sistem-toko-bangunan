<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Invoice Retur</title>

    <style>

        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #000;
            font-family: "Courier New", monospace;
            font-size: 11px;
            line-height: 1.4;
        }

        .print-receipt {
            width: 76mm;
            max-width: 76mm;
            margin: auto;
            padding: 4mm;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 6px;
        }

        .receipt-header h2 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 2px;
        }

        .receipt-header p {
            margin: 2px 0;
        }

        .receipt-divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .receipt-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
        }

        .receipt-info div {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .receipt-items {
            margin-top: 5px;
        }

        .receipt-item {
            margin-bottom: 8px;
        }

        .receipt-product {
            font-weight: bold;
        }

        .receipt-item-detail {
            display: flex;
            justify-content: space-between;
            padding-left: 8px;
            font-size: 10px;
        }

        .receipt-summary div {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .receipt-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 15px;
            margin: 5px 0;
        }

        .receipt-payment {
            margin-top: 5px;
        }

        .receipt-payment div {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
        }

        .receipt-payment .important {
            font-weight: bold;
            font-size: 13px;
        }

        .receipt-section-title {
            font-weight: bold;
            margin: 8px 0 5px;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
        }

        @page {
            size: 80mm auto;
            margin: 4mm;
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

            <span>Jumlah Item</span>

            <span>
                {{ $returnSale->details->count() }}
            </span>

        </div>


        <div>

            <span>Total Qty</span>

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

        <span>TOTAL RETUR</span>

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

                <span>Nilai Barang Pengganti</span>

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

                    <span>SELISIH DIBAYAR</span>

                    <span>

                        Rp {{ number_format($returnSale->selisih_bayar,0,',','.') }}

                    </span>

                </div>

                <div>

                    <span>Status</span>

                    <span>Sudah Dibayar</span>

                </div>

            @else

                <div class="important">

                    <span>PEMBAYARAN</span>

                    <span>Rp 0</span>

                </div>

                <div>

                    <span>Status</span>

                    <span>Tidak Ada Selisih</span>

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

                <span>UANG DIKEMBALIKAN</span>

                <span>

                    Rp {{ number_format($returnSale->total_retur,0,',','.') }}

                </span>

            </div>

            <div>

                <span>Status</span>

                <span>Sudah Dikembalikan</span>

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

                <span>Keterangan</span>

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

        <p>Retur berhasil diproses.</p>

        <p>Simpan invoice ini sebagai bukti retur.</p>

        <br>

        <strong>☺ Terima Kasih ☺</strong>

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