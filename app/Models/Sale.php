<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [

        'kode_penjualan',
        'tanggal',
        'subtotal',
        'diskon',
        'total_bayar',
        'bayar',
        'kembalian'

    ];

    public function details()
    {
        return $this->hasMany(
            SaleDetail::class
        );
    }

    public function returns()
    {
        return $this->hasMany(
            ReturnSale::class
        );
    }
}
