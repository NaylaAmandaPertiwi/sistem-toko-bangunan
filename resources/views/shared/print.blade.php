<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Struk {{ $sale->kode_penjualan }}
    </title>

    <style>

        *{

            margin:0;
            padding:0;
            box-sizing:border-box;

        }

        body{

            font-family:Courier New, monospace;
            font-size:13px;
            width:80mm;
            margin:auto;
            color:#000;

        }

        .center{

            text-align:center;

        }

        .title{

            font-size:18px;
            font-weight:bold;

        }

        .line{

            border-top:1px dashed #000;
            margin:10px 0;

        }

        table{

            width:100%;
            border-collapse:collapse;

        }

        td{

            vertical-align:top;
            padding:2px 0;

        }

        .right{

            text-align:right;

        }

        .footer{

            margin-top:15px;

            text-align:center;

            font-size:12px;

        }

        @media print{

            @page{

                margin:5mm;

            }

        }

    </style>

</head>

<body>

<div class="center">

    <div class="title">

        TOKO BANGUNAN NAYLA

    </div>

    Jl. ....

    <br>

    Telp. ....

</div>

<div class="line"></div>

<table>

    <tr>

        <td>No</td>

        <td class="right">

            {{ $sale->kode_penjualan }}

        </td>

    </tr>

    <tr>

        <td>Tanggal</td>

        <td class="right">

            {{ \Carbon\Carbon::parse($sale->tanggal)->format('d-m-Y H:i') }}

        </td>

    </tr>

    <tr>

        <td>Kasir</td>

        <td class="right">

            {{ $sale->user->name }}

        </td>

    </tr>

</table>

<div class="line"></div>

@foreach($sale->saleDetails as $item)

<table>

    <tr>

        <td colspan="2">

            {{ $item->product->nama_produk }}

        </td>

    </tr>

    <tr>

        <td>

            {{ $item->qty }}

            x

            Rp {{ number_format($item->harga,0,',','.') }}

        </td>

        <td class="right">

            Rp {{ number_format($item->subtotal,0,',','.') }}

        </td>

    </tr>

</table>

@endforeach

<div class="line"></div>

<table>

    <tr>

        <td>

            Subtotal

        </td>

        <td class="right">

            Rp {{ number_format($sale->subtotal,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td>

            Diskon

        </td>

        <td class="right">

            Rp {{ number_format($sale->diskon,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td>

            <strong>Total</strong>

        </td>

        <td class="right">

            <strong>

                Rp {{ number_format($sale->total_bayar,0,',','.') }}

            </strong>

        </td>

    </tr>

    <tr>

        <td>

            Bayar

        </td>

        <td class="right">

            Rp {{ number_format($sale->bayar,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td>

            Kembali

        </td>

        <td class="right">

            Rp {{ number_format($sale->kembalian,0,',','.') }}

        </td>

    </tr>

</table>

<div class="line"></div>

<div class="footer">

    Terima Kasih

    <br>

    Telah Berbelanja

    <br><br>

    Barang yang sudah dibeli

    tidak dapat ditukar

    kecuali sesuai ketentuan.

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