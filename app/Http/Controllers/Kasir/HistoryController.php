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
}
