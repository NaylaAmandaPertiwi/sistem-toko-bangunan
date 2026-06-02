<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockInController extends Controller
{
    public function stockIn()
    {
        return view('inventory.stok-masuk');
    }

    public function stockOut()
    {
        return view('inventory.stok-keluar');
    }

    public function stockOpname()
    {
        return view('inventory.stok-opname');
    }

    public function stockMovement()
    {
        return view('inventory.pergerakan-stok');
    }

    public function stockWarning()
    {
        return view('inventory.peringatan-stok');
    }
}
