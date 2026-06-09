<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index()
    {
        return view('inventory.stok-keluar');
    }

    public function create()
    {
        return view('inventory.create-stock-out');
    }
}
