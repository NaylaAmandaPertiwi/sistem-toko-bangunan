<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('return_sales', function (Blueprint $table) {

            $table->string('return_type')
                ->default('uang')
                ->after('sale_id');

            $table->decimal('total_pengganti', 15, 2)
                ->default(0)
                ->after('total_retur');

            $table->decimal('selisih_bayar', 15, 2)
                ->default(0)
                ->after('total_pengganti');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_sales', function (Blueprint $table) {

            $table->dropColumn([
                'return_type',
                'total_pengganti',
                'selisih_bayar',
            ]);

        });
    }
};