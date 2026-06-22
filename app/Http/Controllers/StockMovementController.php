<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements =
            StockMovement::with('product')
            ->latest()
            ->get();

        return view(
            'inventory.stock-movement',
            compact('movements')
        );
    }
}