<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->string('sumber', 50)->change();

            $table->string('referensi', 50)
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('cash_transactions', function (Blueprint $table) {
            $table->string('sumber', 255)->change();

            $table->string('referensi', 255)
                ->nullable()
                ->change();
        });
    }
};