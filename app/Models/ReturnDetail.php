<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnDetail extends Model
{
    use HasFactory;

    protected $fillable = [

        'return_sale_id',
        'product_id',
        'qty',
        'harga',
        'subtotal'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Header Retur
    |--------------------------------------------------------------------------
    */

    public function returnSale()
    {
        return $this->belongsTo(
            ReturnSale::class
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