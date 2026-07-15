<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Sale;
use App\Models\ReturnDetail;

class ReturnSale extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',

        'kode_retur',

        'sale_id',

        'tanggal',

        'total_retur',

        'keterangan'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Penjualan
    |--------------------------------------------------------------------------
    */

    public function sale()
    {
        return $this->belongsTo(
            Sale::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Detail Retur
    |--------------------------------------------------------------------------
    */

    public function details()
    {
        return $this->hasMany(
            ReturnDetail::class
        );
    }
}