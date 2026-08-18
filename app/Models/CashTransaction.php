<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    use HasFactory;

    protected $fillable = [

        'tanggal',

        'jenis',

        'sumber',

        'referensi',

        'nominal',

        'keterangan',

    ];

    protected $casts = [

        'tanggal' => 'date',

        'nominal' => 'decimal:2',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi ke ReturnSale
    |--------------------------------------------------------------------------
    */

    public function returnSale()
    {
        return $this->belongsTo(
            ReturnSale::class,
            'referensi',
            'kode_retur'
        );
    }
}