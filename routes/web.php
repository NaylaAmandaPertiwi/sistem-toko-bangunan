<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\SupplierController;

use App\Http\Controllers\InventoryController;

use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StockWarningController;



use App\Http\Controllers\DiscountController;

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
    | PRODUK
    |--------------------------------------------------------------------------
    */

    // produk
    Route::delete(
        '/produk/bulk-delete',
        [ProductController::class, 'bulkDelete']
    )->name('produk.bulkDelete');

    Route::resource(
        'produk',
        ProductController::class

    );

    // kategori produk
    Route::resource(
        'kategori-produk',
        CategoryController::class
    );

    // barcode
    Route::get('/barcode',
        [ProductController::class, 'barcode']);


    /*
    |--------------------------------------------------------------------------
    |  SUPPLIER
    |--------------------------------------------------------------------------
    */

    // supplier
    Route::resource(
        'supplier',
        SupplierController::class
    );

    Route::get(
        '/supplier-export',
        [SupplierController::class,'export']
    )->name('supplier.export');
        

    /*
    |--------------------------------------------------------------------------
    | INVENTORY
    |--------------------------------------------------------------------------
    */    

    // Inventory
    Route::get('/inventory',
        [InventoryController::class,'index']);

        /*
        |--------------------------------------------------------------------------
        | STOK MASUK
        |--------------------------------------------------------------------------
        */ 

    // Menampilkan daftar stok masuk
    Route::get('/stok-masuk',
        [StockInController::class,'index'])
        ->name('stok-masuk.index');

    // Menampilkan form tambah stok masuk
    Route::get('/stok-masuk/create',
        [StockInController::class,'create'])
        ->name('stok-masuk.create');

    // Menyimpan data stok masuk baru
    Route::post('/stok-masuk',
        [StockInController::class,'store'])
        ->name('stok-masuk.store');

    // Menampilkan form edit stok masuk
    Route::get('/stok-masuk/{id}/edit',
        [StockInController::class,'edit'])
        ->name('stok-masuk.edit');

    // Menyimpan hasil edit stok masuk
    Route::put('/stok-masuk/{id}',
        [StockInController::class,'update'])
        ->name('stok-masuk.update');

    // Hapus banyak data sekaligus
    Route::delete('/stok-masuk/bulk-delete',
        [StockInController::class,'bulkDelete'])
        ->name('stok-masuk.bulkDelete');

        /*
        |--------------------------------------------------------------------------
        | STOK OPNAME
        |--------------------------------------------------------------------------
        */     

    // stok opname

    Route::get(
        '/stok-opname',
        [StockOpnameController::class,'index']
    )->name('stok-opname.index');

    Route::get(
        '/stok-opname/create',
        [StockOpnameController::class,'create']
    )->name('stok-opname.create');

    Route::post(
        '/stok-opname',
        [StockOpnameController::class,'store']
    )->name('stok-opname.store');

    Route::get(
        '/stok-opname/{id}',
        [StockOpnameController::class,'show']
    )->name('stok-opname.show');

    

    // pergerakan stok    
    Route::get('/pergerakan-stok',
        [StockMovementController::class,'index']);

    // peringatan stok
    Route::get('/peringatan-stok',
        [StockWarningController::class,'index']);



    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */

    // penjualan
    Route::get('/penjualan', function () {
        return view('transaksi.penjualan');
    });

    // retur barang
    Route::get('/retur', function () {
        return view('transaksi.retur');
    });

    // riwayat transaksi
    Route::get('/riwayat-transaksi', function () {
        return view('transaksi.riwayat-transaksi');
    });


    /*
    |--------------------------------------------------------------------------
    | DISKON
    |--------------------------------------------------------------------------
    */

    // diskon
    Route::get('/diskon',
        [DiscountController::class,'index']);

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

    // laporan barang terlaris
    Route::get('/laporan-barang-terlaris', function () {
        return view('laporan.barang-terlaris');
    });

    // laporan keuangan
    Route::get('/laporan-keuangan', function () {
        return view('laporan.keuangan');
    });

    
});