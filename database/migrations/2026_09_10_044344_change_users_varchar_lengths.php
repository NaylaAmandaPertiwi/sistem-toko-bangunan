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
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 100)->change();

            $table->string('username', 50)
                ->nullable()
                ->change();

            $table->string('email', 100)
                ->nullable()
                ->change();

            $table->string('password', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 255)->change();

            $table->string('username', 255)
                ->nullable()
                ->change();

            $table->string('email', 255)
                ->nullable()
                ->change();

            $table->string('password', 255)->change();
        });
    }
};