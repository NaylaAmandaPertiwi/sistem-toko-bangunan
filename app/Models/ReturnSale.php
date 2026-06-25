<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnSale extends Model
{
    use HasFactory;

    protected $fillable = [

        'kode_retur',
        'sale_id',
        'tanggal',
        'total_retur',
        'keterangan'

    ];

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