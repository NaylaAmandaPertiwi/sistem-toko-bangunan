<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnSale;

class ReturnPrintController extends Controller
{
    public function print(ReturnSale $returnSale)
    {
        $returnSale->load([
            'user',
            'sale',
            'details.product',
            'details.saleDetail'
        ]);

        return view(
            'shared.print-return',
            compact('returnSale')
        );
    }
}