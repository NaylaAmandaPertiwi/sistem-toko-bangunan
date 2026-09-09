<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beban_operasionals', function (Blueprint $table) {
            $table->string('jenis_beban', 50)->change();
        });
    }

    public function down(): void
    {
        Schema::table('beban_operasionals', function (Blueprint $table) {
            $table->string('jenis_beban', 255)->change();
        });
    }
};