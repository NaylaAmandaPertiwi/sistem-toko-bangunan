<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Sale;
use App\Models\Product;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [

        'sale_id',

        'product_id',

        'qty',

        'harga',

        'subtotal'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Penjualan
    |--------------------------------------------------------------------------
    */

    public function sale()
    {
        return $this->belongsTo(

            Sale::class,

            'sale_id'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Produk
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(

            Product::class,

            'product_id'

        );
    }
}