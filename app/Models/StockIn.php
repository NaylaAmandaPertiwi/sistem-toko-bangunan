<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $fillable = [
        'nomor_transaksi',
        'supplier_id',
        'product_id',
        'tanggal_masuk',
        'jumlah_masuk',
        'harga_beli'
    ];
}
