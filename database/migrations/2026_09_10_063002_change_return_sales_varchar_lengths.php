<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_sales', function (Blueprint $table) {
            $table->string('kode_retur', 30)->change();

            $table->string('return_type', 20)
                ->default('uang')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('return_sales', function (Blueprint $table) {
            $table->string('kode_retur', 255)->change();

            $table->string('return_type', 255)
                ->default('uang')
                ->change();
        });
    }
};