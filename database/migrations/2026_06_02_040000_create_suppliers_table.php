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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            $table->string('nama_supplier');
            $table->string('kontak_person')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->text('catatan')->nullable();

            $table->string('foto')->nullable();

            $table->string('negara')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kode_pos')->nullable();
            $table->text('alamat')->nullable();

            $table->enum('status',['Aktif','Nonaktif'])
                ->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
