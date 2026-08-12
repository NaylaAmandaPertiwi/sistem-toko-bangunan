<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function keuangan()
    {
        return view('admin.laporan.keuangan');
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