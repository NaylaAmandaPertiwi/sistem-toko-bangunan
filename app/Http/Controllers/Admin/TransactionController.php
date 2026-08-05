<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;

class TransactionController extends Controller
{
    public function penjualan(Request $request)
    {

        $sales = $this->filterSales($request)
            ->paginate(10)
            ->withQueryString();

        $cashiers = User::where('role', 'Kasir')
            ->orderBy('name')
            ->get();

        $filter = $request->get('filter', 'all');

        return view(
            'admin.transaksi.penjualan',
            compact(
                'sales',
                'cashiers',
                'filter'
            )
        );
    }

    public function search(Request $request)
    {
        $sales = $this->filterSales($request)
            ->paginate(10);

        return response()->json($sales);
    }

    private function filterSales(Request $request)
    {
        $query = Sale::with('user');

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
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

                $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);

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

            $query->where('user_id', $request->kasir);

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

        return $query->latest('tanggal');
    }

    public function retur()
    {
        return view('admin.transaksi.retur');
    }
}
