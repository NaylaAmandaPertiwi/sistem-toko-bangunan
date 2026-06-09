<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $fillable = [
        'nomor_transaksi',
        'product_id',
        'tanggal_keluar',
        'jumlah_keluar',
        'harga_jual',
        'total',
        'tujuan',
        'Petugas'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
