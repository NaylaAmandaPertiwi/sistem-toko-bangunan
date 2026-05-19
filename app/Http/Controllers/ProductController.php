<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = [
            [
                'kode' => 'BRG001',
                'nama' => 'Semen Padang',
                'kategori' => 'Material',
                'harga' => '75000',
                'stok' => '50',
            ],

            [
                'kode' => 'BRG002',
                'nama' => 'Cat Nippon',
                'kategori' => 'Cat',
                'harga' => '120000',
                'stok' => '20',
            ],

            [
                'kode' => 'BRG003',
                'nama' => 'Besi Beton',
                'kategori' => 'Besi',
                'harga' => '95000',
                'stok' => '40',
            ],
        ];

        return view('products.data_barang', compact('products'));
    }
}