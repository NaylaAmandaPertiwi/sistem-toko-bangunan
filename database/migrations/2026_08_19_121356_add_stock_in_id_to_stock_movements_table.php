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
        Schema::table('stock_movements', function (Blueprint $table) {

            $table->foreignId('stock_in_id')
                ->nullable()
                ->after('product_id')
                ->constrained('stock_ins')
                ->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {

            $table->dropForeign([
                'stock_in_id'
            ]);

            $table->dropColumn(
                'stock_in_id'
            );

        });
    }
};