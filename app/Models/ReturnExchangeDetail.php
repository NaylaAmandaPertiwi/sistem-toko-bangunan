<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\ReturnSale;
use App\Models\Product;

class ReturnExchangeDetail extends Model
{
    protected $fillable = [
        'return_sale_id',
        'product_id',
        'qty',
        'harga',
        'subtotal',
    ];

    protected $casts = [
        'qty' => 'integer',
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Retur
    |--------------------------------------------------------------------------
    */

    public function returnSale(): BelongsTo
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

    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class
        );
    }
}