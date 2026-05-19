<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // contoh data (nanti bisa dari database)
        $data = [
            'total_transaksi' => 140,
            'stok_menipis' => 5,
            'total_penjualan' => 50000000,
            'diskon_aktif' => 5
        ];

        return view('dashboard', compact('data'));
    }
}