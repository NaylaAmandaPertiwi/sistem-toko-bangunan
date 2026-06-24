<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [

        'nama_diskon',
        'minimal_belanja',
        'persentase_diskon',
        'status'

    ];
}