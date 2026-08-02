<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\ReturnSale;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index()
    {

        App::setLocale('id');
        Carbon::setLocale('id');

        $selectedDate = request('date')
            ? Carbon::parse(request('date'))
            : Carbon::today();

        return view(
            'kasir.dashboard',
            $this->dashboardData($selectedDate) + [
                'selectedDate'=>$selectedDate
            ]
        );
    }

    private function dashboardData(Carbon $selectedDate)
    {
        $today = $selectedDate;

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

            $date = $today->copy()->subDays($i);

            $weeklySales[] = [

                'tanggal' => $date->translatedFormat('d M'),

                'total' => (float) Sale::whereDate('tanggal', $date)
                                ->sum('total_bayar')

            ];

        }

        /*
        |--------------------------------------------------------------------------
        | Notifikasi Barang Stok Minimum
        |--------------------------------------------------------------------------
        */

        $lowStockProducts = Product::whereColumn(
                'stok',
                '<=',
                'stok_minimum'
            )
            ->orderBy('stok', 'asc')
            ->get();

        $lowStockCount = $lowStockProducts->count();

        /*
        |--------------------------------------------------------------------------
        | Top 5 Produk Terlaris
        |--------------------------------------------------------------------------
        */

        $topProducts = SaleDetail::select('product_id')
            ->selectRaw('SUM(qty) as total_terjual')
            ->with('product')
            ->whereHas('sale', function ($query) use ($today) {

                $query->whereDate('tanggal', $today);

            })
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        $topProducts->transform(function ($item) {

            $item->total_terjual = (int) $item->total_terjual;

            return $item;

        });

        $chartStartDate = $selectedDate
            ->copy()
            ->subDays(6)
            ->translatedFormat('d M Y');

        $chartEndDate = $selectedDate
            ->translatedFormat('d M Y');

        return [

            'salesToday'        => (int) $salesToday,
            'returnsToday'      => (int) $returnsToday,
            'revenueToday'      => (float) $revenueToday,
            'productsSoldToday' => (int) $productsSoldToday,

            'weeklySales'       => $weeklySales,

            'topProducts'       => $topProducts,

            // Notifikasi
            'lowStockProducts'  => $lowStockProducts,
            'lowStockCount'     => $lowStockCount,

            'chartStartDate'    => $chartStartDate,
            'chartEndDate'      => $chartEndDate,

        ];
    }

    public function getDashboardData(Request $request)
    {
        $selectedDate = $request->date
            ? Carbon::parse($request->date)
            : Carbon::today();

        return response()->json(
            $this->dashboardData($selectedDate)
        );
    }
}