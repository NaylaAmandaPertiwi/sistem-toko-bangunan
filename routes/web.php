<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockInController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| AUTH LOGIN
|--------------------------------------------------------------------------
*/

// halaman login
Route::get('/login',
    [AuthController::class, 'showLogin'])
    ->name('login');

// proses login
Route::post('/login',
    [AuthController::class, 'login']);

// logout
Route::post('/logout',
    [AuthController::class, 'logout'])
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| SEMUA HALAMAN SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard',
        [DashboardController::class, 'index']);



    /*
    |--------------------------------------------------------------------------
    | PRODUK & INVENTORY
    |--------------------------------------------------------------------------
    */

    // produk
    Route::get('/produk',
        [ProductController::class, 'index']);

    // kategori produk
    Route::get('/kategori-produk',
        [CategoryController::class, 'index']);

    Route::post('/kategori-produk',
        [CategoryController::class, 'store']);


    // inventory
    Route::get('/inventory', function () {
        return view('inventory');
    });

    // stok masuk
    Route::get('/stok-masuk',
        [StockInController::class, 'stockIn']);

    // stok keluar
    Route::get('/stok-keluar',
        [InventoryController::class, 'stockOut']);

        // stok opname
    Route::get('/stok-opname',
        [InventoryController::class, 'stockOpname']);

        // pergerakan stok
    Route::get('/pergerakan-stok',
        [InventoryController::class, 'stockMovement']);

        // peringatan stok
    Route::get('/peringatan-stok',
        [InventoryController::class, 'stockWarning']);


    // cetak barcode
    Route::get('/barcode', function () {
        return view('barcode');
    });

    // cetak label harga
    Route::get('/label-harga', function () {
        return view('label-harga');
    });



    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */

    // penjualan
    Route::get('/penjualan', function () {
        return view('penjualan');
    });

    // pembayaran
    Route::get('/pembayaran', function () {
        return view('pembayaran');
    });

    // retur barang
    Route::get('/retur-barang', function () {
        return view('retur-barang');
    });

    // riwayat transaksi
    Route::get('/riwayat-transaksi', function () {
        return view('riwayat-transaksi');
    });



    /*
    |--------------------------------------------------------------------------
    | PEGAWAI
    |--------------------------------------------------------------------------
    */

    // staff
    Route::get('/staff', function () {
        return view('staff');
    });

    // kehadiran
    Route::get('/kehadiran', function () {
        return view('kehadiran');
    });



    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    // laporan penjualan
    Route::get('/laporan-penjualan', function () {
        return view('laporan.penjualan');
    });

    // laporan stok
    Route::get('/laporan-stok', function () {
        return view('laporan.stok');
    });

    // laporan barang masuk
    Route::get('/laporan-barang-masuk', function () {
        return view('laporan.barang-masuk');
    });

    // laporan barang keluar
    Route::get('/laporan-barang-keluar', function () {
        return view('laporan.barang-keluar');
    });

    // laporan keuangan
    Route::get('/laporan-keuangan', function () {
        return view('laporan.keuangan');
    });

    
});