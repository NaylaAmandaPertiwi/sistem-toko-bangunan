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
use App\Http\Controllers\StockAlertController;

use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReturnController;

use App\Http\Controllers\DiscountController;



use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\SaleController as KasirSaleController;
use App\Http\Controllers\Kasir\ReturnController as KasirReturnController;
use App\Http\Controllers\Kasir\HistoryController as KasirHistoryController;

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
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Route Admin akan dipindahkan ke sini secara bertahap
            //Dashboard
            Route::get(
                '/dashboard',
                [\App\Http\Controllers\Admin\DashboardController::class,'index']
            )->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | PRODUK
            |--------------------------------------------------------------------------
            */

            // produk
            Route::delete(
                '/produk/bulk-delete',
                [\App\Http\Controllers\Admin\ProductController::class, 'bulkDelete']
            )->name('produk.bulkDelete');

            Route::resource(
                'produk',
                \App\Http\Controllers\Admin\ProductController::class

            );

            // kategori produk
            Route::resource(
                'kategori-produk',
                \App\Http\Controllers\Admin\CategoryController::class
            );

            // barcode
            Route::get(
                '/barcode',
                [\App\Http\Controllers\Admin\ProductController::class, 'barcode']
            )->name('barcode');

            /*
            |--------------------------------------------------------------------------
            | SUPPLIER
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/supplier-export',
                [\App\Http\Controllers\Admin\SupplierController::class, 'export']
            )->name('supplier.export');

            Route::resource(
                'supplier',
                \App\Http\Controllers\Admin\SupplierController::class
            );

            /*
            |--------------------------------------------------------------------------
            | INVENTORY
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/inventory',
                [\App\Http\Controllers\Admin\InventoryController::class, 'index']
            )->name('inventory');

                /*
                |--------------------------------------------------------------------------
                | STOK MASUK
                |--------------------------------------------------------------------------
                */

            Route::get(
                '/stok-masuk',
                [\App\Http\Controllers\Admin\StockInController::class, 'index']
            )->name('stok-masuk.index');

            Route::get(
                '/stok-masuk/create',
                [\App\Http\Controllers\Admin\StockInController::class, 'create']
            )->name('stok-masuk.create');

            Route::post(
                '/stok-masuk',
                [\App\Http\Controllers\Admin\StockInController::class, 'store']
            )->name('stok-masuk.store');

            Route::get(
                '/stok-masuk/{id}/edit',
                [\App\Http\Controllers\Admin\StockInController::class, 'edit']
            )->name('stok-masuk.edit');

            Route::put(
                '/stok-masuk/{id}',
                [\App\Http\Controllers\Admin\StockInController::class, 'update']
            )->name('stok-masuk.update');

            Route::delete(
                '/stok-masuk/bulk-delete',
                [\App\Http\Controllers\Admin\StockInController::class, 'bulkDelete']
            )->name('stok-masuk.bulkDelete');

                /*
                |--------------------------------------------------------------------------
                | STOK OPNAME
                |--------------------------------------------------------------------------
                */

            Route::get(
                '/stok-opname',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'index']
            )->name('stok-opname.index');

            Route::get(
                '/stok-opname/create',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'create']
            )->name('stok-opname.create');

            Route::post(
                '/stok-opname',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'store']
            )->name('stok-opname.store');

            Route::delete(
                '/stok-opname/bulk-delete',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'bulkDelete']
            )->name('stok-opname.bulk-delete');

            Route::put(
                '/stok-opname/{id}/status',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'updateStatus']
            )->name('stok-opname.update-status');

            Route::get(
                '/stok-opname/{id}/print',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'print']
            )->name('stok-opname.print');

            Route::get(
                '/stok-opname/{id}/pdf',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'pdf']
            )->name('stok-opname.pdf');

            Route::get(
                '/stok-opname/{id}',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'show']
            )->name('stok-opname.show');

                /*
                |--------------------------------------------------------------------------
                | PERGERAKAN STOK
                |--------------------------------------------------------------------------
                */
            Route::get(
                '/stock-movement',
                [\App\Http\Controllers\Admin\StockMovementController::class,'index']
            )->name('stock-movement.index');

                /*
                |--------------------------------------------------------------------------
                | PERINGATAN STOK
                |--------------------------------------------------------------------------
                */ 

            Route::get(
                '/peringatan-stok',
                [\App\Http\Controllers\Admin\StockAlertController::class,'index']
            )->name('stock-alert.index');

            /*
            |--------------------------------------------------------------------------
            | DISKON
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/diskon',
                [\App\Http\Controllers\Admin\DiscountController::class,'index']
            )->name('discount.index');

            Route::get(
                '/diskon/create',
                [\App\Http\Controllers\Admin\DiscountController::class, 'create']
            )->name('discount.create');

            Route::get(
                '/diskon/{discount}/edit',
                [\App\Http\Controllers\Admin\DiscountController::class,'edit']
            )->name('discount.edit');

            Route::post(
                '/diskon',
                [\App\Http\Controllers\Admin\DiscountController::class, 'store']
            )->name('discount.store');

            Route::put(
                '/diskon/{discount}',
                [\App\Http\Controllers\Admin\DiscountController::class, 'update']
            )->name('discount.update');

            Route::delete(
                '/diskon/{discount}',
                [\App\Http\Controllers\Admin\DiscountController::class, 'destroy']
            )->name('discount.destroy');

            

        });

    /*
    |--------------------------------------------------------------------------
    | KASIR
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth','role:Kasir'])
        ->prefix('kasir')
        ->name('kasir.')
        ->group(function () {

            Route::get('/dashboard',
                [KasirDashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('/penjualan',
                [KasirSaleController::class, 'index'])
                ->name('penjualan.index');

            Route::get('/retur',
                [KasirReturnController::class, 'index'])
                ->name('retur.index');

            Route::get('/riwayat-transaksi',
                [KasirHistoryController::class, 'index'])
                ->name('riwayat.index');





    });

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    //Route::get('/dashboard',
        //[DashboardController::class, 'index']);


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

    Route::delete(
        '/stok-opname/bulk-delete',
        [StockOpnameController::class,'bulkDelete']
    )->name('stok-opname.bulk-delete');

   Route::put(
        '/stok-opname/{id}/status',
        [StockOpnameController::class,'updateStatus']
    )->name('stok-opname.update-status');

    Route::get(
        '/stok-opname/{id}/print',
        [StockOpnameController::class,'print']
    )->name('stok-opname.print');

    Route::get(
        '/stok-opname/{id}',
        [StockOpnameController::class,'show']
    )->name('stok-opname.show');

    /*
        |--------------------------------------------------------------------------
        | PERGERAKAN STOK
        |--------------------------------------------------------------------------
        */ 
    
    // pergerakan stok    
        Route::get(
        '/stock-movement',
        [StockMovementController::class,'index']
    )->name('stock-movement.index');


        /*
        |--------------------------------------------------------------------------
        | PERINGATAN STOK
        |--------------------------------------------------------------------------
        */ 

    // peringatan stok
    Route::get(
        '/peringatan-stok',
        [StockAlertController::class,'index']
    )->name('stock-alert.index');


    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */

        /*
        |--------------------------------------------------------------------------
        | PENJUALAN
        |--------------------------------------------------------------------------
        */ 

    // penjualan
    Route::get(
        '/penjualan',
        [SaleController::class, 'index']
    )->name('penjualan.index');

    Route::post(
    '/penjualan/simpan',
        [SaleController::class,'store']
    )->name('penjualan.store');


    /*
        |--------------------------------------------------------------------------
        | RETUR BARANG
        |--------------------------------------------------------------------------
        */ 

    // retur barang
    Route::get(
        '/retur',
        [ReturnController::class,'index']
    )->name('retur.index');

    Route::get(
        '/retur/create',
        [ReturnController::class,'create']
    )->name('retur.create');

    Route::post(
        '/retur',
        [ReturnController::class,'store']
    )->name('retur.store');

    Route::get(
        '/retur/{retur}',
        [ReturnController::class,'show']
    )->name('retur.show');

    Route::delete(
        '/retur/{retur}',
        [ReturnController::class,'destroy']
    )->name('retur.destroy');



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
    Route::resource(
        'diskon',
        DiscountController::class
    );

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