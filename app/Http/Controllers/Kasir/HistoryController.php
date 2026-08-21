<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\ReturnSale;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        $filter = $request->filter;

        $tanggal = $request->tanggal;


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $search = trim($request->search ?? '');


        /*
        |--------------------------------------------------------------------------
        | QUERY PENJUALAN
        |--------------------------------------------------------------------------
        */

        $salesQuery = Sale::with('user');


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL PENJUALAN
        |--------------------------------------------------------------------------
        */

        switch ($filter) {

            case 'today':

                $salesQuery->whereDate(
                    'tanggal',
                    today()
                );

                break;


            case 'yesterday':

                $salesQuery->whereDate(
                    'tanggal',
                    today()->subDay()
                );

                break;


            case 'week':

                $salesQuery->whereBetween(
                    'tanggal',
                    [
                        today()->subDays(6),
                        today()
                    ]
                );

                break;


            case 'month':

                $salesQuery
                    ->whereYear(
                        'tanggal',
                        today()->year
                    )
                    ->whereMonth(
                        'tanggal',
                        today()->month
                    );

                break;


            case 'custom':

                if ($tanggal) {

                    $salesQuery->whereDate(
                        'tanggal',
                        $tanggal
                    );

                }

                break;

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH PENJUALAN
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $salesQuery->where(function ($query) use ($search) {

                $query->where(
                    'kode_penjualan',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas(
                    'user',
                    function ($userQuery) use ($search) {

                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );

                    }
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION PENJUALAN
        |--------------------------------------------------------------------------
        */

        $sales = $salesQuery
            ->latest('tanggal')
            ->paginate(
                10,
                ['*'],
                'sales_page'
            )
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | QUERY RETUR
        |--------------------------------------------------------------------------
        */

        $returnSalesQuery = ReturnSale::with([
            'sale',
            'user',
            'cashTransaction'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL RETUR
        |--------------------------------------------------------------------------
        */

        switch ($filter) {

            case 'today':

                $returnSalesQuery->whereDate(
                    'tanggal',
                    today()
                );

                break;


            case 'yesterday':

                $returnSalesQuery->whereDate(
                    'tanggal',
                    today()->subDay()
                );

                break;


            case 'week':

                $returnSalesQuery->whereBetween(
                    'tanggal',
                    [
                        today()->subDays(6),
                        today()
                    ]
                );

                break;


            case 'month':

                $returnSalesQuery
                    ->whereYear(
                        'tanggal',
                        today()->year
                    )
                    ->whereMonth(
                        'tanggal',
                        today()->month
                    );

                break;


            case 'custom':

                if ($tanggal) {

                    $returnSalesQuery->whereDate(
                        'tanggal',
                        $tanggal
                    );

                }

                break;

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH RETUR
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $returnSalesQuery->where(function ($query) use ($search) {

                $query->where(
                    'kode_retur',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas(
                    'user',
                    function ($userQuery) use ($search) {

                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        );

                    }
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION RETUR
        |--------------------------------------------------------------------------
        */

        $returnSales = $returnSalesQuery
            ->latest('tanggal')
            ->paginate(
                10,
                ['*'],
                'returns_page'
            )
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'kasir.riwayat.index',
            compact(
                'sales',
                'returnSales',
                'filter',
                'tanggal',
                'search'
            )
        );
    }

    public function showSale(Sale $sale)
    {
        $sale->load([

            'user',

            'saleDetails.product'

        ]);

        return view(

            'kasir.riwayat.detail-penjualan',

            compact('sale')

        );
    }

    public function showReturn(ReturnSale $returnSale)
    {
        $returnSale->load([

            'user',

            'sale',

            'details.product',

            'details.saleDetail',

            'exchangeDetails.product',

            'cashTransaction'

        ]);

        return view(

            'kasir.riwayat.detail-retur',

            compact('returnSale')

        );
    }
}
