<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('sale_details')
            ->orderBy('id')
            ->chunkById(500, function ($details) {
                foreach ($details as $detail) {

                    $hargaBeli = DB::table('products')
                        ->where('id', $detail->product_id)
                        ->value('harga_beli');

                    DB::table('sale_details')
                        ->where('id', $detail->id)
                        ->update([
                            'harga_beli' => $hargaBeli ?? 0
                        ]);
                }
            });
    }

    public function down(): void
    {
        DB::table('sale_details')
            ->update([
                'harga_beli' => 0
            ]);
    }
};