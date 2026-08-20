<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Cetak Barcode - {{ $product->nama_produk }}
    </title>

    <style>

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            padding:30px;

            font-family:Arial, sans-serif;

            background:#f5f6fa;

            color:#111;
        }

        .barcode-card{
            width:400px;

            margin:0 auto;

            background:white;

            padding:30px;

            border-radius:12px;

            text-align:center;

            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }

        .product-name{
            font-size:20px;
            font-weight:bold;

            margin-bottom:8px;
        }

        .product-sku{
            font-size:14px;

            color:#666;

            margin-bottom:20px;
        }

        .barcode{
            margin:15px auto;
        }

        .barcode svg{
            width:280px;
            height:90px;
        }

        .barcode-number{
            margin-top:8px;

            font-size:16px;

            letter-spacing:2px;
        }

        .print-button{
            margin-top:25px;

            padding:10px 20px;

            border:none;

            border-radius:8px;

            background:#1684e0;

            color:white;

            font-size:14px;

            cursor:pointer;
        }

        @media print{

            body{
                background:white;
                padding:0;
            }

            .barcode-card{
                box-shadow:none;
            }

            .print-button{
                display:none;
            }

        }

    </style>

</head>

<body>

@php

    $generator =
        new \Picqer\Barcode\BarcodeGeneratorSVG();

@endphp


<div class="barcode-card">

    <div class="product-name">

        {{ $product->nama_produk }}

    </div>


    <div class="product-sku">

        SKU: {{ $product->sku }}

    </div>


    <div class="barcode">

        @if($product->barcode)

            {!! $generator->getBarcode(
                $product->barcode,
                $generator::TYPE_CODE_128
            ) !!}

            <div class="barcode-number">

                {{ $product->barcode }}

            </div>

        @else

            <p>
                Produk ini belum memiliki barcode.
            </p>

        @endif

    </div>


    <button
        type="button"
        class="print-button"
        onclick="window.print()">

        🖨 Cetak Barcode

    </button>

</div>


</body>

</html>