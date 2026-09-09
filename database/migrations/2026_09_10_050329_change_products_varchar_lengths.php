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
        Schema::table('products', function (Blueprint $table) {
            $table->string('nama_produk', 100)->change();

            $table->string('sku', 50)
                ->nullable()
                ->change();

            $table->string('barcode', 50)
                ->nullable()
                ->change();

            $table->string('satuan', 30)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('nama_produk', 255)->change();

            $table->string('sku', 255)
                ->nullable()
                ->change();

            $table->string('barcode', 255)
                ->nullable()
                ->change();

            $table->string('satuan', 255)->change();
        });
    }
};