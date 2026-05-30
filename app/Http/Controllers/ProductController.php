<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view(
            'products.index',
            compact('categories')
        );
    }
}