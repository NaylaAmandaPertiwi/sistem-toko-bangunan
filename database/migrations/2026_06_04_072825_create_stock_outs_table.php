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
        Schema::create('stock_outs', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_transaksi')->unique();

            $table->foreignId('product_id');

            $table->date('tanggal_keluar');

            $table->integer('jumlah_keluar');

            $table->decimal('harga_jual',15,2);

            $table->decimal('total',15,2);

            $table->string('tujuan');

            $table->text('petugas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
