<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesReportExport;

class SalesReportController extends Controller
{

    /**
     * Membuat label periode untuk laporan
     */
    private function getPeriodLabel(Request $request)
    {
        $filter = $request->get('filter', 'all');

        switch ($filter) {

            case 'today':

                return now()->format('d/m/Y');


            case 'yesterday':

                return now()
                    ->subDay()
                    ->format('d/m/Y');


            case 'week':

                return now()
                    ->subDays(6)
                    ->format('d/m/Y')
                    . ' - ' .
                    now()->format('d/m/Y');


            case 'month':

                \Carbon\Carbon::setLocale('id');

                return now()->translatedFormat('F Y');


            case 'custom':

                if ($request->filled('tanggal')) {

                    return \Carbon\Carbon::parse(
                        $request->tanggal
                    )->format('d/m/Y');

                }

                return 'Tanggal Tidak Dipilih';


            default:

                return 'Semua Periode';
        }
    }

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
        $query = Sale::with('user');

        /*
        |--------------------------------------------------------------------------
        | FILTER PERIODE
        |--------------------------------------------------------------------------
        */

        $filter = $request->get('filter', 'all');

        $periodLabel = $this->getPeriodLabel($request);

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
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $totalTransaksi = $sales->count();

        $totalPenjualan = $sales->sum('total_bayar');

        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'admin.laporan.pdf.penjualan',
            compact(
                'sales',
                'filter',
                'periodLabel',
                'totalTransaksi',
                'totalPenjualan'
            )
        );

        return $pdf->stream(
            'laporan-penjualan.pdf'
        );
    }

    
    /**
     * Export Laporan Penjualan Excel
     */
    public function penjualanExcel(Request $request)
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
        | FILTER KODE PENJUALAN
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
        | LABEL PERIODE
        |--------------------------------------------------------------------------
        */

        switch ($filter) {

            case 'today':

                $periodLabel =
                    'Hari Ini, ' .
                    now()->format('d/m/Y');

                break;

            case 'yesterday':

                $periodLabel =
                    'Kemarin, ' .
                    now()->subDay()->format('d/m/Y');

                break;

            case 'week':

                $periodLabel =
                    now()->subDays(6)->format('d/m/Y') .
                    ' - ' .
                    now()->format('d/m/Y');

                break;

            case 'month':

                $periodLabel =
                    now()->translatedFormat('F Y');

                break;

            case 'custom':

                if ($request->filled('tanggal')) {

                    $periodLabel =
                        \Carbon\Carbon::parse(
                            $request->tanggal
                        )->format('d/m/Y');

                } else {

                    $periodLabel = 'Tanggal Tertentu';

                }

                break;

            default:

                $periodLabel = 'Semua Periode';

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | EXPORT EXCEL
        |--------------------------------------------------------------------------
        */

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SalesReportExport(
                $sales,
                $filter,
                $periodLabel,
                $request->tanggal,
                $request->kasir,
                $request->kode
            ),
            'laporan-penjualan.xlsx'
        );
    }
}