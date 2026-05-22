<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>@yield('title')</title>

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

/* SIDEBAR */
.sidebar{
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#4e73df,#355cc9);
    position:fixed;
    left:0;
    top:0;
    padding:20px;
    color:white;
    overflow-y:auto;
}

.logo{
    font-size:24px;
    font-weight:700;
    margin-bottom:30px;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 14px;
    color:white;
    text-decoration:none;
    border-radius:10px;
    margin-bottom:6px;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.15);
}

.active{
    background:white;
    color:#355cc9 !important;
}

/* CONTENT */
.content{
    margin-left:260px;
    padding:30px;
}

</style>

@yield('styles')

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        Nayla Bangunan
    </div>

    <a href="/dashboard">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>

    <a href="/produk">
        <i class="fa-solid fa-box"></i>
        Produk
    </a>

    <a href="/kategori-produk">
        <i class="fa-solid fa-layer-group"></i>
        Kategori Produk
    </a>

</div>

<!-- CONTENT -->
<div class="content">

    @yield('content')

</div>

@yield('scripts')

</body>
</html>