<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\ReturnSale;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('kasir.dashboard', $this->dashboardData());
    }

    private function dashboardData()
    {
        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Statistik Hari Ini
        |--------------------------------------------------------------------------
        */

        $salesToday = Sale::whereDate('tanggal', $today)->count();

        $returnsToday = ReturnSale::whereDate('tanggal', $today)->count();

        $revenueToday = Sale::whereDate('tanggal', $today)
                            ->sum('total_bayar');

        $productsSoldToday = SaleDetail::whereHas('sale', function ($query) use ($today) {

            $query->whereDate('tanggal', $today);

        })->sum('qty');

        /*
        |--------------------------------------------------------------------------
        | Grafik Penjualan 7 Hari Terakhir
        |--------------------------------------------------------------------------
        */

        $weeklySales = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            $weeklySales[] = [

                'tanggal' => $date->translatedFormat('D'),

                'total' => Sale::whereDate('tanggal', $date)
                                ->sum('total_bayar')

            ];

        }

        /*
        |--------------------------------------------------------------------------
        | Top 5 Produk Terlaris
        |--------------------------------------------------------------------------
        */

        $topProducts = SaleDetail::select('product_id')
            ->selectRaw('SUM(qty) as total_terjual')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return [

            'salesToday' => $salesToday,
            'returnsToday' => $returnsToday,
            'revenueToday' => $revenueToday,
            'productsSoldToday' => $productsSoldToday,
            'weeklySales' => $weeklySales,
            'topProducts' => $topProducts,

        ];
    }
}