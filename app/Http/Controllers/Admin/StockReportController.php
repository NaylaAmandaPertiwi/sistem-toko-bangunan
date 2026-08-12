<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function stok()
    {
        return view('admin.laporan.stok');
    }

    public function stokPdf()
    {
        //
    }

    public function stokExcel()
    {
        //
    }
}