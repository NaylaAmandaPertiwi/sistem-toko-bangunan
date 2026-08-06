<?php

namespace App\Http\Controllers;

use App\Models\Sale;

class SalePrintController extends Controller
{
    public function print(Sale $sale)
    {
        $sale->load([
            'user',
            'saleDetails.product'
        ]);

        return view('shared.print-sale', compact('sale'));
    }
}