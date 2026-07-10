<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SaleDetail;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'nama_produk',
        'sku',
        'barcode',
        'stok',
        'stok_minimum',
        'satuan',
        'harga_beli',
        'harga_jual',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function returnDetails()
    {
        return $this->hasMany(
            ReturnDetail::class
        );
    }

    public function saleDetails()
    {
        return $this->hasMany(
            SaleDetail::class
        );
    }
}
