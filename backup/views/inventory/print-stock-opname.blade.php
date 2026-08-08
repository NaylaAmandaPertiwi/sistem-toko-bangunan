<!DOCTYPE html>
<html>
<head>
    <title>Cetak Stok Opname</title>

    <style>

    body{
        font-family:Arial,sans-serif;
        margin:30px;
    }

    table{
        width:100%;
        border-collapse:collapse;
        margin-top:20px;
    }

    table,
    th,
    td{
        border:1px solid #000;
    }

    th,
    td{
        padding:8px;
    }

    h2{
        text-align:center;
    }

    </style>
</head>
<body>

<h2>Nayla Bangunan</h2>

<p>
<b>No Opname:</b>
{{ $opname->nomor_opname }}
</p>

<p>
<b>Tanggal:</b>
{{ date('d-m-Y', strtotime($opname->tanggal_opname)) }}
</p>

<p>
<b>Petugas:</b>
{{ $opname->petugas }}
</p>

<p>
<b>Status:</b>
{{ $opname->status }}
</p>

<p>
<b>Keterangan:</b>
{{ $opname->keterangan }}
</p>

<table>

    <thead>

        <tr>
            <th>Produk</th>
            <th>SKU</th>
            <th>Stok Sistem</th>
            <th>Stok Fisik</th>
            <th>Selisih</th>
        </tr>

    </thead>

    <tbody>

    @foreach($opname->details as $detail)

        <tr>

            <td>
                {{ $detail->product->nama_produk }}
            </td>

            <td>
                {{ $detail->product->sku }}
            </td>

            <td>
                {{ $detail->stok_sistem }}
            </td>

            <td>
                {{ $detail->stok_fisik }}
            </td>

            <td>
                {{ $detail->selisih }}
            </td>

        </tr>

    @endforeach

    </tbody>

</table>

<script>
window.print();
</script>

</body>
</html>