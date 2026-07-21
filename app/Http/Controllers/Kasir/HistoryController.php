<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\ReturnSale;

class HistoryController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')
            ->latest()
            ->paginate(10, ['*'], 'sales_page');

        $returnSales = ReturnSale::with([
                'sale',
                'user'
            ])
            ->latest()
            ->paginate(10, ['*'], 'returns_page');

        return view(
            'kasir.riwayat.index',
            compact(
                'sales',
                'returnSales'
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

            'details.saleDetail'

        ]);

        return view(

            'kasir.riwayat.detail-retur',

            compact('returnSale')

        );
    }
}
