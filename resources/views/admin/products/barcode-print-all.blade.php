<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cetak Semua Barcode</title>

    <style>

        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            padding:30px;
            font-family:Arial, sans-serif;
            background:white;
            color:#111;
        }

        .barcode-container{

            display:grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap:25px;

            width:100%;

        }

        .barcode-item{

            text-align:center;

            padding:15px;

            page-break-inside:avoid;

        }

        .product-name{

            font-size:16px;

            font-weight:700;

            margin-bottom:5px;

        }

        .sku{

            font-size:12px;

            color:#666;

            margin-bottom:12px;

        }

        .barcode-image{

            max-width:100%;

            height:60px;

        }

        .barcode-number{

            font-size:12px;

            margin-top:6px;

            letter-spacing:2px;

        }

        .no-barcode{

            font-size:12px;

            color:#999;

        }

        @media print{

            body{

                padding:10px;

            }

            .barcode-container{

                gap:15px;

            }

        }

    </style>

</head>

<body>

    <div class="barcode-container">

        @forelse($products as $product)

            <div class="barcode-item">

                <div class="product-name">

                    {{ $product->nama_produk }}

                </div>

                <div class="sku">

                    SKU: {{ $product->sku }}

                </div>

                @if($product->barcode)

                    @php

                        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();

                        $barcodeSvg = $generator->getBarcode(
                            $product->barcode,
                            $generator::TYPE_CODE_128
                        );

                    @endphp

                    <div class="barcode-image">

                        {!! $barcodeSvg !!}

                    </div>

                    <div class="barcode-number">

                        {{ $product->barcode }}

                    </div>

                @else

                    <span class="no-barcode">

                        Tidak ada barcode

                    </span>

                @endif

            </div>

        @empty

            <div style="
                grid-column:1 / -1;
                text-align:center;
                padding:50px;
            ">

                Tidak ada produk yang dapat dicetak.

            </div>

        @endforelse

    </div>

    <script>

        window.onload = function(){

            window.print();

        };

    </script>

</body>

</html>