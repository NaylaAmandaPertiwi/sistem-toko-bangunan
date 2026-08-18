<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Sale;
use App\Models\ReturnDetail;
use App\Models\ReturnExchangeDetail;
use App\Models\CashTransaction;

class ReturnSale extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',

        'kode_retur',

        'sale_id',

        'return_type',

        'tanggal',

        'total_retur',

        'total_pengganti',

        'selisih_bayar',

        'keterangan'

    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_retur' => 'decimal:2',
        'total_pengganti' => 'decimal:2',
        'selisih_bayar' => 'decimal:2',
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

    /*
    |--------------------------------------------------------------------------
    | Relasi ke Detail Barang Pengganti
    |--------------------------------------------------------------------------
    */

    public function exchangeDetails()
    {
        return $this->hasMany(
            ReturnExchangeDetail::class
        );
    }

    public function cashTransaction()
    {
        return $this->hasOne(
            CashTransaction::class,
            'referensi',
            'kode_retur'
        );
    }
}