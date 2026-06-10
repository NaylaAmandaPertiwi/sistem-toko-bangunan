<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [

            'total_produk'      => 250,
            'total_supplier'    => 15,
            'total_transaksi'   => 32,
            'total_penjualan'   => 7500000

        ];

        return view('dashboard', compact('data'));
    }
}