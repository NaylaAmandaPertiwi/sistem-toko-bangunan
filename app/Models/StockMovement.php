<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOpname;

class StockMovement extends Model
{
    protected $fillable = [

        'stock_in_id',

        'stock_opname_id',

        'product_id',

        'tanggal',

        'jenis',

        'qty',

        'stok_awal',

        'stok_akhir',

        'keterangan'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Stock In
    |--------------------------------------------------------------------------
    */

    public function stockIn()
    {
        return $this->belongsTo(
            StockIn::class,
            'stock_in_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Stock Opname
    |--------------------------------------------------------------------------
    */

    public function stockOpname()
    {
        return $this->belongsTo(
            StockOpname::class,
            'stock_opname_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Produk
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }
}