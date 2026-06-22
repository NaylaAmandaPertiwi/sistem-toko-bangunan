<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $fillable = [

        'nomor_opname',

        'tanggal_opname',

        'petugas',

        'keterangan',

        'status'
    ];

    public function details()
    {
        return $this->hasMany(
            StockOpnameDetail::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'petugas'
        );
    }
}