<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockAlertController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if($request->filled('search'))
        {
            $query->where(
                'nama_produk',
                'like',
                '%' . $request->search . '%'
            );
        }

        if($request->filled('status'))
        {
            if($request->status == 'habis')
            {
                $query->where('stok', 0);
            }

            if($request->status == 'menipis')
            {
                $query->whereColumn(
                    'stok',
                    '<=',
                    'stok_minimum'
                )
                ->where('stok','>',0);
            }
        }

        $products = $query
            ->orderBy('stok')
            ->get();

        return view(
            'inventory.stock-alert',
            compact('products')
        );
    }
}