<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->string('nomor_opname', 30)->change();

            $table->string('status', 20)
                ->default('Selesai')
                ->change();

            $table->string('petugas', 50)
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->string('nomor_opname', 255)->change();

            $table->string('status', 255)
                ->default('Selesai')
                ->change();

            $table->string('petugas', 255)
                ->nullable()
                ->change();
        });
    }
};