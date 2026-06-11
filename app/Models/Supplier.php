<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

        protected $fillable = [

        'nama_supplier',
        'kontak_person',
        'email',
        'telepon',
        'catatan',

        'foto',

        'negara',
        'provinsi',
        'kota',
        'kode_pos',
        'alamat',

        'status'
    ];
}
