<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_ins';

    protected $fillable = [
        'nomor_transaksi',
        'tanggal_masuk',
        'supplier_id',
        'product_id',
        'jumlah_masuk',
        'harga_beli',
        'keterangan'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}