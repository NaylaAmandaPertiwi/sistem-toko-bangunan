<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with('product');

        // Filter Produk
        if($request->filled('product_id'))
        {
            $query->where(
                'product_id',
                $request->product_id
            );
        }

        // Filter Jenis
        if($request->filled('jenis'))
        {
            $query->where(
                'jenis',
                $request->jenis
            );
        }

        // Filter Tanggal
        if(
            $request->filled('start_date')
            &&
            $request->filled('end_date')
        )
        {
            $query->whereBetween(
                'tanggal',
                [
                    $request->start_date,
                    $request->end_date
                ]
            );
        }

        $movements = $query
            ->latest()
            ->get();

        $products = Product::orderBy(
            'nama_produk'
        )->get();

        return view(
            'inventory.stock-movement',
            compact(
                'movements',
                'products'
            )
        );
    }
}