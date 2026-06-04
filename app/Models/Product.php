<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'nama_produk',
        'sku',
        'barcode',
        'stok',
        'satuan',
        'harga_beli',
        'harga_jual',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }
}
