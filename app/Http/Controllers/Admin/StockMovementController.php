<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with('product');

        if($request->filled('search'))
        {
            $query->whereHas(
                'product',
                function($q) use ($request){

                    $q->where(
                        'nama_produk',
                        'like',
                        '%' . $request->search . '%'
                    );

                }
            );
        }

        // Filter Produk
        if($request->filled('product_id'))
        {
            $query->where(
                'product_id',
                $request->product_id
            );
        }

        // Filter Jenis
        if(
            $request->has('jenis')
            &&
            $request->jenis != ''
        )
        {
            $query->where(
                'jenis',
                $request->jenis
            );
        }

        // Filter Tanggal
        $filter = $request->get('filter', 'all');

        switch ($filter) {

            case 'today':

                $query->whereDate(
                    'tanggal',
                    now()
                );

                break;


            case 'yesterday':

                $query->whereDate(
                    'tanggal',
                    now()->subDay()
                );

                break;


            case 'week':

                $query->whereBetween(
                    'tanggal',
                    [
                        now()->subDays(6)->startOfDay(),
                        now()->endOfDay()
                    ]
                );

                break;


            case 'month':

                $query->whereMonth(
                    'tanggal',
                    now()->month
                )
                ->whereYear(
                    'tanggal',
                    now()->year
                );

                break;


            case 'custom':

                if ($request->filled('tanggal')) {

                    $query->whereDate(
                        'tanggal',
                        $request->tanggal
                    );

                }

                break;

        }

        $movements = $query
            ->latest()
            ->get();

        $products = Product::orderBy(
            'nama_produk'
        )->get();

        return view(
            'admin.inventory.stock-movement',
            compact(
                'movements',
                'products'
            )
        );
    }
}