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
        Schema::create('cash_transactions', function (Blueprint $table) {

            $table->id();

            $table->date('tanggal');

            $table->enum('jenis', [
                'masuk',
                'keluar'
            ]);

            $table->string('sumber');

            $table->string('referensi')->nullable();

            $table->decimal('nominal', 15, 2);

            $table->text('keterangan')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_transactions');
    }
};