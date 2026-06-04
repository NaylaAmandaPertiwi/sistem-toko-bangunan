<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockWarningController extends Controller
{
    public function index()
    {
        return view('inventory.peringatan-stok');
    }
}
