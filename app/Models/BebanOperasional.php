<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BebanOperasional extends Model
{
    protected $table = 'beban_operasionals';

    protected $fillable = [
        'tanggal',
        'jenis_beban',
        'nominal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];
}