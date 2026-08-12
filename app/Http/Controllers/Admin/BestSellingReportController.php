<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BestSellingReportController extends Controller
{
    public function index()
    {
        return view('admin.laporan.barang-terlaris');
    }

    public function pdf()
    {
        //
    }

    public function excel()
    {
        //
    }
}