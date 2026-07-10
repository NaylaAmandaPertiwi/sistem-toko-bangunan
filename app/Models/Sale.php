<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;
use App\Models\SaleDetail;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',

        'kode_penjualan',

        'tanggal',

        'subtotal',

        'diskon',

        'total_bayar',

        'bayar',

        'kembalian'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Kasir
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(

            User::class,

            'user_id'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Detail Penjualan
    |--------------------------------------------------------------------------
    */

    public function saleDetails()
    {
        return $this->hasMany(

            SaleDetail::class,

            'sale_id'

        );
    }
}