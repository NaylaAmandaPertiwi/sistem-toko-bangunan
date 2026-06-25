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
        Schema::create('sales', function (Blueprint $table) {

            $table->id();

            $table->string('kode_penjualan');

            $table->date('tanggal');

            $table->decimal('subtotal',15,2);

            $table->decimal('diskon',15,2)->default(0);

            $table->decimal('total_bayar',15,2);

            $table->decimal('bayar',15,2);

            $table->decimal('kembalian',15,2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
