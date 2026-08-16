<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\ReturnSale;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TANGGAL DASHBOARD
        |--------------------------------------------------------------------------
        */

        $tanggalInput = request('tanggal');

        if ($tanggalInput) {

            try {

                $tanggalDipilih =
                    Carbon::createFromFormat(
                        'Y-m-d',
                        $tanggalInput
                    );

            } catch (\Exception $e) {

                $tanggalDipilih =
                    Carbon::today();

            }

        } else {

            $tanggalDipilih =
                Carbon::today();

        }

        /*
        |--------------------------------------------------------------------------
        | TOTAL PRODUK
        |--------------------------------------------------------------------------
        */

        $totalProduk = Product::count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL KATEGORI
        |--------------------------------------------------------------------------
        */

        $totalKategori = Category::count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SUPPLIER
        |--------------------------------------------------------------------------
        */

        $totalSupplier = Supplier::count();


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI HARI INI
        |--------------------------------------------------------------------------
        */

        $totalTransaksi = Sale::whereDate(
            'tanggal',
            $tanggalDipilih
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PENDAPATAN HARI INI
        |--------------------------------------------------------------------------
        */

        $totalPenjualan = Sale::whereDate(
            'tanggal',
            $tanggalDipilih
        )->sum('total_bayar');


        /*
        |--------------------------------------------------------------------------
        | GRAFIK PENJUALAN 7 HARI TERAKHIR
        |--------------------------------------------------------------------------
        */

        $tanggalMulaiGrafik =
            $tanggalDipilih->copy()->subDays(6)->startOfDay();

        $tanggalAkhirGrafik =
            $tanggalDipilih->copy()->endOfDay();


        $penjualan7Hari = Sale::select(
            DB::raw('DATE(tanggal) as tanggal'),
            DB::raw('SUM(total_bayar) as total')
        )
            ->whereBetween('tanggal', [
                $tanggalMulaiGrafik,
                $tanggalAkhirGrafik
            ])
            ->groupBy(
                DB::raw('DATE(tanggal)')
            )
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');


        /*
        |--------------------------------------------------------------------------
        | SIAPKAN LABEL DAN DATA GRAFIK
        |--------------------------------------------------------------------------
        */

        $grafikLabels = [];

        $grafikData = [];


        for ($i = 0; $i < 7; $i++) {

            $tanggal =
                $tanggalDipilih->copy()->subDays(6 - $i);

            $tanggalDatabase =
                $tanggal->format('Y-m-d');

            $grafikLabels[] =
                $tanggal->format('d/m');

            $grafikData[] =
                (float) (
                    $penjualan7Hari[$tanggalDatabase] ?? 0
                );
        }

        /*
        |--------------------------------------------------------------------------
        | PERINGATAN STOK
        |--------------------------------------------------------------------------
        */

        $stokMenipis = Product::whereColumn(
            'stok',
            '<=',
            'stok_minimum'
        )
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PRODUK TERLARIS
        |--------------------------------------------------------------------------
        */

        $produkTerlaris = Product::select(
            'products.id',
            'products.nama_produk',
            DB::raw('SUM(sale_details.qty) as total_terjual')
        )
            ->join(
                'sale_details',
                'products.id',
                '=',
                'sale_details.product_id'
            )
            ->groupBy(
                'products.id',
                'products.nama_produk'
            )
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETUR TERBARU
        |--------------------------------------------------------------------------
        */

        $returTerbaru = ReturnSale::with('user')
            ->whereDate('tanggal', $tanggalDipilih)
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DISKON AKTIF
        |--------------------------------------------------------------------------
        */

        $diskonAktif = Discount::where(
            'status',
            'Aktif'
        )
            ->orderByDesc('persentase_diskon')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERAKHIR
        |--------------------------------------------------------------------------
        */

        $transaksiTerakhir = Sale::with('user')
            ->whereDate(
                'tanggal',
                $tanggalDipilih
            )
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DATA DASHBOARD
        |--------------------------------------------------------------------------
        */

        $data = [

            'total_produk' =>
                $totalProduk,

            'total_kategori' =>
                $totalKategori,

            'total_supplier' =>
                $totalSupplier,

            'total_transaksi' =>
                $totalTransaksi,

            'total_penjualan' =>
                $totalPenjualan,

            'grafik_labels' =>
                $grafikLabels,

            'grafik_data' =>
                $grafikData,

            'produk_terlaris' =>
                $produkTerlaris,

            'tanggal_dipilih' =>
                $tanggalDipilih->format('Y-m-d')

        ];


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'data',
                'stokMenipis',
                'transaksiTerakhir',
                'returTerbaru',
                'diskonAktif'
            )
        );
    }
}