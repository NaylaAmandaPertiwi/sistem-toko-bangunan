<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;

use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Admin\SupplierController;

use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\StockInController;
use App\Http\Controllers\Admin\StockOpnameController;
use App\Http\Controllers\Admin\StockMovementController;
use App\Http\Controllers\Admin\StockAlertController;

use App\Http\Controllers\Admin\TransactionController;

use App\Http\Controllers\Admin\DiscountController;
  
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Controllers\Admin\BestSellingReportController;
use App\Http\Controllers\Admin\FinancialReportController;

use App\Http\Controllers\Admin\StaffController;

use App\Http\Controllers\Kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\Kasir\SaleController as KasirSaleController;
use App\Http\Controllers\Kasir\ReturnController as KasirReturnController;
use App\Http\Controllers\Kasir\HistoryController as KasirHistoryController;

use App\Http\Controllers\SalePrintController;
use App\Http\Controllers\ReturnPrintController;

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
| UBAH PASSWORD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/ubah-password',
        [PasswordController::class, 'edit']
    )->name('password.edit');

    Route::post(
        '/ubah-password',
        [PasswordController::class, 'update']
    )->name('password.update');


});


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

            Route::get(
            '/profil',
                [ProfileController::class, 'admin']
            )->name('profil');

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

            Route::get(
                '/barcode/{product}/print', 
                [\App\Http\Controllers\Admin\ProductController::class, 'printBarcode']
            )->name('barcode.print');

            Route::get(
                '/barcode/print-all', 
                [\App\Http\Controllers\Admin\ProductController::class, 'printAllBarcode']
            )->name('barcode.print-all');

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

            Route::get(
                '/stok-opname/{id}/edit',
                [\App\Http\Controllers\Admin\StockOpnameController::class, 'edit']
            )->name('stok-opname.edit');

            Route::put(
                '/stok-opname/{id}',
                [\App\Http\Controllers\Admin\StockOpnameController::class, 'update']
            )->name('stok-opname.update');

            Route::get(
                '/stok-opname/{id}',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'show']
            )->name('stok-opname.show');

            Route::put(
                '/stok-opname/{id}/status',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'updateStatus']
            )->name('stok-opname.update-status');

            Route::delete(
                '/stok-opname/bulk-delete',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'bulkDelete']
            )->name('stok-opname.bulk-delete');

            Route::get(
                '/stok-opname/{id}/print',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'print']
            )->name('stok-opname.print');

            Route::get(
                '/stok-opname/{id}/pdf',
                [\App\Http\Controllers\Admin\StockOpnameController::class,'pdf']
            )->name('stok-opname.pdf');

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
            | TRANSAKSI
            |--------------------------------------------------------------------------
            */
                /*
                |--------------------------------------------------------------------------
                | PENJUALAN
                |--------------------------------------------------------------------------
                */ 

            Route::get(
                '/transaksi/penjualan',
                [\App\Http\Controllers\Admin\TransactionController::class, 'penjualan']
            )->name('transaksi.penjualan');

            Route::get(
                '/transaksi/penjualan/search',
                [\App\Http\Controllers\Admin\TransactionController::class, 'search']
            )->name('transaksi.penjualan.search');

            Route::get(
                '/transaksi/penjualan/{sale}',
                [\App\Http\Controllers\Admin\TransactionController::class, 'show']
            )->name('transaksi.penjualan.show');

            Route::delete(
                '/transaksi/penjualan/{sale}',
                [\App\Http\Controllers\Admin\TransactionController::class, 'destroy']
            )->name('transaksi.penjualan.destroy');

            Route::get(
                '/transaksi/penjualan/{sale}/print',
                [\App\Http\Controllers\Admin\TransactionController::class, 'print']
            )->name('transaksi.penjualan.print');

                /*
                |--------------------------------------------------------------------------
                | RETUR
                |--------------------------------------------------------------------------
                */

            Route::get(
                '/transaksi/retur',
                [\App\Http\Controllers\Admin\TransactionController::class, 'retur']
            )->name('transaksi.retur');
            
            Route::get(
                '/transaksi/retur/search',
                [\App\Http\Controllers\Admin\TransactionController::class, 'searchReturn']
            )->name('transaksi.retur.search');

            Route::get(
                '/transaksi/retur/{returnSale}',
                [\App\Http\Controllers\Admin\TransactionController::class, 'showReturn']
            )->name('transaksi.retur.show');

            Route::delete(
                '/transaksi/retur/{returnSale}', 
                [\App\Http\Controllers\Admin\TransactionController::class,'destroyReturn']
            )->name('transaksi.retur.destroy');

            Route::get(
                '/transaksi/retur/{returnSale}/print',
                [\App\Http\Controllers\Admin\TransactionController::class, 'printReturn']
            )->name('transaksi.retur.print');



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


            /*
            |--------------------------------------------------------------------------
            | LAPORAN
            |--------------------------------------------------------------------------
            */

                /*
                |--------------------------------------------------------------------------
                | Laporan Penjualan
                |--------------------------------------------------------------------------
                */

            Route::get(
                '/laporan/penjualan',
                [\App\Http\Controllers\Admin\SalesReportController::class, 'penjualan']
            )->name('laporan.penjualan');

            Route::get(
                '/laporan/penjualan/pdf',
                [\App\Http\Controllers\Admin\SalesReportController::class, 'penjualanPdf']
            )->name('laporan.penjualan.pdf');

            Route::get(
                '/laporan/penjualan/excel',
                [\App\Http\Controllers\Admin\SalesReportController::class, 'penjualanExcel']
            )->name('laporan.penjualan.excel');

                /*
                |--------------------------------------------------------------------------
                | Laporan Stok
                |--------------------------------------------------------------------------
                */

            Route::get(
                '/laporan/stok',
                [\App\Http\Controllers\Admin\StockReportController::class, 'stok']
            )->name('laporan.stok');

            Route::get(
                '/laporan/stok/pdf', 
                [\App\Http\Controllers\Admin\StockReportController::class, 'stokPdf']
                )->name('laporan.stok.pdf');

            Route::get(
                '/laporan/stok/excel',
                [\App\Http\Controllers\Admin\StockReportController::class, 'stokExcel']
            )->name('laporan.stok.excel');

            Route::get(
                '/laporan/stok/filter',
                [\App\Http\Controllers\Admin\StockReportController::class, 'filter']
            )->name('laporan.stok.filter');

                /*
                |--------------------------------------------------------------------------
                | Laporan Barang Terlaris
                |--------------------------------------------------------------------------
                */

            Route::get(
                '/laporan/barang-terlaris',
                [\App\Http\Controllers\Admin\BestSellingReportController::class, 'index']
            )->name('laporan.barang-terlaris');

            Route::get(
                '/laporan/barang-terlaris/pdf',
                [\App\Http\Controllers\Admin\BestSellingReportController::class, 'pdf']
            )->name('laporan.barang-terlaris.pdf');
    
            Route::get(
                '/laporan/barang-terlaris/excel',
                [\App\Http\Controllers\Admin\BestSellingReportController::class, 'excel']
            )->name('laporan.barang-terlaris.excel');

                /*
                |--------------------------------------------------------------------------
                | Laporan Keuangan
                |--------------------------------------------------------------------------
                */

            Route::get(
                '/laporan/keuangan',
                [\App\Http\Controllers\Admin\FinancialReportController::class, 'index']
            )->name('laporan.keuangan');

            Route::get(
                '/laporan/keuangan/pdf',
                [\App\Http\Controllers\Admin\FinancialReportController::class, 'pdf']
            )->name('laporan.keuangan.pdf');

            Route::get(
                '/laporan/keuangan/excel',
                [\App\Http\Controllers\Admin\FinancialReportController::class, 'excel']
            )->name('laporan.keuangan.excel');

            /*
            |--------------------------------------------------------------------------
            | MANAJEMEN KASIR
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/staff',
                [\App\Http\Controllers\Admin\StaffController::class, 'index']
            )->name('staff.index');

            Route::get(
                '/staff/create',
                [\App\Http\Controllers\Admin\StaffController::class, 'create']
            )->name('staff.create');

            Route::post(
                '/staff',
                [\App\Http\Controllers\Admin\StaffController::class, 'store']
            )->name('staff.store');

            Route::patch(
                '/staff/{id}/deactivate',
                [\App\Http\Controllers\Admin\StaffController::class, 'deactivate']
            )->name('staff.deactivate');

            Route::patch(
                '/staff/{id}/activate',
                [\App\Http\Controllers\Admin\StaffController::class, 'activate']
            )->name('staff.activate');

            Route::get(
                '/staff/{staff}/reset-password',
                [\App\Http\Controllers\Admin\StaffController::class, 'resetPasswordForm']
            )->name('staff.reset-password');

            Route::post(
                '/staff/{staff}/reset-password',
                [\App\Http\Controllers\Admin\StaffController::class, 'resetPassword']
            )->name('staff.reset-password.update');
                        

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

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/dashboard',
                [KasirDashboardController::class,'index']
            )->name('dashboard');

            Route::get('/dashboard/data', 
                [KasirDashboardController::class, 'getDashboardData']
            )->name('dashboard.data');

            Route::get(
                '/profil',
                [ProfileController::class, 'kasir']
            )->name('profil');

            /*
            |--------------------------------------------------------------------------
            | PENJUALAN
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/penjualan',
                [KasirSaleController::class,'index']
            )->name('penjualan.index');

            Route::get(
                '/produk/search',
                [KasirSaleController::class,'searchProduct']
            )->name('produk.search');

            Route::get(
                '/produk/barcode/{barcode}',
                [KasirSaleController::class, 'searchBarcode']
            )->name('produk.barcode');

            Route::post(
                '/penjualan',
                [KasirSaleController::class, 'store']
            )->name('penjualan.store');

            Route::get(
                '/penjualan/{sale}/print',
                [KasirSaleController::class,'print']
            )->name('penjualan.print');

            /*
            |--------------------------------------------------------------------------
            | RETUR
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/retur',
                [KasirReturnController::class,'index']
            )->name('retur.index');

            Route::get(
                '/retur/transactions', 
                [KasirReturnController::class,'transactionData']
            )->name('retur.transactions');

            Route::get(
                '/retur/create',
                [KasirReturnController::class,'create']
            )->name('retur.create');

            Route::get(
                '/retur/{sale}/detail',
                [KasirReturnController::class,'detail']
            )->name('retur.detail');

            Route::post(
                '/retur',
                [KasirReturnController::class,'store']
            )->name('retur.store');

            Route::get(
                '/retur/{retur}',
                [KasirReturnController::class,'show']
            )->name('retur.show');

            Route::delete(
                '/retur/{retur}',
                [KasirReturnController::class,'destroy']
            )->name('retur.destroy');


            /*
            |--------------------------------------------------------------------------
            | RIWAYAT TRANSAKSI
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/riwayat-transaksi',
                [KasirHistoryController::class,'index']
            )->name('riwayat.index');

            Route::get(
                '/riwayat-transaksi/penjualan/{sale}',
                [KasirHistoryController::class,'showSale']
            )->name('riwayat.sale.show');

            Route::get(
                '/riwayat-transaksi/retur/{returnSale}',
                [KasirHistoryController::class,'showReturn']
            )->name('riwayat.return.show');

        });

    /*
    |--------------------------------------------------------------------------
    | PRINT GLOBAL
    |--------------------------------------------------------------------------
    */

        Route::get(
            '/print/sale/{sale}',
            [SalePrintController::class, 'print']
        )->name('print.sale');

        Route::get(
            '/print/return/{returnSale}',
            [ReturnPrintController::class, 'print']
        )->name('print.return');



    });