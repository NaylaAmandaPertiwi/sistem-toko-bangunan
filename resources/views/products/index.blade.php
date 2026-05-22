<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Produk</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI', sans-serif;
    background:#f5f7fb;
}

/* CONTENT */
.content{
    padding:30px;
}

/* HEADER */
.page-header{
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

/* TOP HEADER */
.top-header{
    background:#1684e0;
    color:white;
    padding:18px 25px;
    font-size:28px;
    font-weight:600;
}

/* TAB */
.tab-menu{
    display:flex;
    background:white;
    border-bottom:1px solid #eee;
}

.tab-menu a{
    flex:1;
    text-align:center;
    padding:18px;
    text-decoration:none;
    color:#444;
    font-weight:600;
    transition:0.3s;
}

.tab-menu a:hover{
    background:#f3f5fa;
}

.tab-menu .active{
    color:#1684e0;
    border-bottom:3px solid #1684e0;
}

/* FILTER */
.filter-section{
    padding:25px;
    display:flex;
    justify-content:space-between;
    gap:15px;
    flex-wrap:wrap;
}

.left-filter{
    display:flex;
    gap:15px;
}

.filter-box{
    background:white;
    border:1px solid #ddd;
    border-radius:10px;
    padding:12px 16px;
    min-width:160px;
}

.search-box{
    flex:1;
}

.search-box input{
    width:100%;
    padding:12px 16px;
    border:1px solid #ddd;
    border-radius:10px;
}

/* BUTTON */
.add-btn{
    background:#4CAF50;
    color:white;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
}

.add-btn:hover{
    background:#43a047;
}

/* TABLE */
.table-section{
    padding:25px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:12px;
    overflow:hidden;
}

table th{
    background:#f3f5fa;
    padding:16px;
    text-align:left;
}

table td{
    padding:16px;
    border-bottom:1px solid #eee;
}

.no-data{
    text-align:center;
    padding:40px;
    color:#999;
}

</style>
</head>

<body>

<div class="content">

    <div class="page-header">

        <!-- HEADER -->
        <div class="top-header">

            Katalog Produk

        </div>

        <!-- TAB -->
        <div class="tab-menu">

            <a href="/produk"
               class="active">

               Produk

            </a>

            <a href="#">

               Kategori Produk

            </a>

        </div>

        <!-- FILTER -->
        <div class="filter-section">

            <div class="left-filter">

                <div class="filter-box">
                    Semua Kategori
                </div>

            </div>

            <div class="search-box">

                <input type="text"
                       placeholder="Cari Produk">

            </div>

            <button class="add-btn">

                <i class="fa-solid fa-plus"></i>
                Tambah Produk

            </button>

        </div>

        <!-- TABLE -->
        <div class="table-section">

            <table>

                <tr>

                    <th>Nama Produk</th>
                    <th>SKU</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>

                </tr>

                <tr>

                    <td colspan="5"
                        class="no-data">

                        Belum ada produk

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>

</body>
</html>