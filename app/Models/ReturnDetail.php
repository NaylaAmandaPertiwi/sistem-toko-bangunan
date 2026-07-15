<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\ReturnSale;

class ReturnDetail extends Model
{
    use HasFactory;

    protected $fillable = [

        'return_sale_id',

        'sale_detail_id',

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
    | Relasi Detail Penjualan
    |--------------------------------------------------------------------------
    */

    public function saleDetail()
    {
        return $this->belongsTo(SaleDetail::class);
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