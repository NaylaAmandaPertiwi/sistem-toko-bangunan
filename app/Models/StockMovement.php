<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [

        'product_id',
        'tanggal',
        'jenis',
        'qty',
        'stok_awal',
        'stok_akhir',
        'keterangan'

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}