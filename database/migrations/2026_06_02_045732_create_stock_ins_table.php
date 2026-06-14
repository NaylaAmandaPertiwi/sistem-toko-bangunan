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
        Schema::create('stock_ins', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_transaksi')->unique();

            $table->foreignId('supplier_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');

            $table->date('tanggal_masuk');

            $table->integer('jumlah_masuk');

            $table->decimal('harga_beli',15,2);

            $table->timestamps();

            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
