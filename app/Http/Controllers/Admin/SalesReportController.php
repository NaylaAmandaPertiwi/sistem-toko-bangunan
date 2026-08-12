<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;

class SalesReportController extends Controller
{
    /**
     * Laporan Penjualan
     */
    public function penjualan(Request $request)
    {
        $query = Sale::with('user');

        /*
        |--------------------------------------------------------------------------
        | FILTER PERIODE
        |--------------------------------------------------------------------------
        */

        $filter = $request->get('filter', 'all');

        switch ($filter) {

            case 'today':

                $query->whereDate('tanggal', now());

                break;

            case 'yesterday':

                $query->whereDate(
                    'tanggal',
                    now()->subDay()
                );

                break;

            case 'week':

                $query->whereBetween(
                    'tanggal',
                    [
                        now()->subDays(6)->startOfDay(),
                        now()->endOfDay()
                    ]
                );

                break;

            case 'month':

                $query->whereMonth(
                    'tanggal',
                    now()->month
                )->whereYear(
                    'tanggal',
                    now()->year
                );

                break;

            case 'custom':

                if ($request->filled('tanggal')) {

                    $query->whereDate(
                        'tanggal',
                        $request->tanggal
                    );

                }

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KASIR
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kasir')) {

            $query->where(
                'user_id',
                $request->kasir
            );

        }

        /*
        |--------------------------------------------------------------------------
        | PENCARIAN KODE PENJUALAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kode')) {

            $query->where(
                'kode_penjualan',
                'like',
                '%' . trim($request->kode) . '%'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | DATA PENJUALAN
        |--------------------------------------------------------------------------
        */

        $sales = $query
            ->latest('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA KASIR
        |--------------------------------------------------------------------------
        */

        $cashiers = User::where(
            'role',
            'Kasir'
        )
        ->orderBy('name')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalTransaksi = $sales->count();

        $totalPenjualan = $sales->sum('total_bayar');

        return view(
            'admin.laporan.penjualan',
            compact(
                'sales',
                'cashiers',
                'filter',
                'totalTransaksi',
                'totalPenjualan'
            )
        );
    }

    /**
     * Cetak Laporan Penjualan PDF
     */
    public function penjualanPdf(Request $request)
    {
        // Akan kita kerjakan setelah halaman laporan
        // berhasil dipindahkan ke controller baru.
    }

    /**
     * Export Laporan Penjualan Excel
     */
    public function penjualanExcel(Request $request)
    {
        // Akan kita kerjakan setelah PDF.
    }
}