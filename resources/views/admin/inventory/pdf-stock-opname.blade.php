<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Laporan Stok Opname</title>

<style>

@page{
    size:A4 portrait;
    margin:20mm;
}

body{
    font-family:Arial,Helvetica,sans-serif;
    color:#222;
    font-size:14px;
}

.header{
    text-align:center;
    margin-bottom:25px;
}

.header h1{
    margin:0;
    font-size:28px;
}

.header h2{
    margin:8px 0;
    font-size:20px;
}

.header p{
    margin:2px 0;
    color:#666;
}

.line{
    border-top:3px solid #000;
    border-bottom:1px solid #000;
    margin-top:15px;
    margin-bottom:25px;
    height:3px;
}

.info-table{
    width:100%;
    margin-bottom:25px;
}

.info-table td{
    padding:5px 0;
    vertical-align:top;
}

.info-table td:first-child{
    width:180px;
    font-weight:bold;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f1f1f1;
}

table,
th,
td{
    border:1px solid black;
}

th,
td{
    padding:10px;
    text-align:left;
}

tfoot td{
    font-weight:bold;
}

.signature{
    width:100%;
    margin-top:70px;
}

.signature td{
    width:50%;
    text-align:center;
}

.signature .space{
    height:80px;
}

.print-date{
    text-align:right;
    margin-top:40px;
}

</style>

</head>

<body>

<div class="header">

    <h1>TOKO BANGUNAN NAYLA</h1>

    <h2>LAPORAN STOK OPNAME</h2>

    <p>
        Jl. .............................................
    </p>

</div>

<div class="line"></div>

<table class="info-table">

<tr>
    <td>No Opname</td>
    <td>: {{ $opname->nomor_opname }}</td>
</tr>

<tr>
    <td>Tanggal</td>
    <td>: {{ date('d-m-Y',strtotime($opname->tanggal_opname)) }}</td>
</tr>

<tr>
    <td>Petugas</td>
    <td>: {{ $opname->petugas }}</td>
</tr>

<tr>
    <td>Status</td>
    <td>: {{ $opname->status }}</td>
</tr>

<tr>
    <td>Keterangan</td>
    <td>: {{ $opname->keterangan ?? '-' }}</td>
</tr>

</table>

<table>

<thead>

<tr>

<th width="35">No</th>

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

<td>{{ $loop->iteration }}</td>

<td>{{ $detail->product->nama_produk }}</td>

<td>{{ $detail->product->sku }}</td>

<td>{{ $detail->stok_sistem }}</td>

<td>{{ $detail->stok_fisik }}</td>

<td>{{ $detail->selisih }}</td>

</tr>

@endforeach

</tbody>

</table>

<div class="print-date">

Padang,
{{ now()->translatedFormat('d F Y') }}

</div>

<table class="signature">

<tr>

<td>

Mengetahui,

<br>

Owner

</td>

<td>

Petugas

</td>

</tr>

<tr>

<td class="space"></td>

<td class="space"></td>

</tr>

<tr>

<td>

(__________________)

</td>

<td>

({{ $opname->petugas }})

</td>

</tr>

</table>

<script>

window.onload=function(){

    window.print();

}

</script>

</body>
</html>