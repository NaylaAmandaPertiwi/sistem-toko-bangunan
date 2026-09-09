<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('nama_supplier', 100)->change();

            $table->string('kontak_person', 100)
                ->nullable()
                ->change();

            $table->string('email', 100)
                ->nullable()
                ->change();

            $table->string('telepon', 20)
                ->nullable()
                ->change();

            $table->string('negara', 50)
                ->nullable()
                ->change();

            $table->string('provinsi', 100)
                ->nullable()
                ->change();

            $table->string('kota', 100)
                ->nullable()
                ->change();

            $table->string('kode_pos', 10)
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('nama_supplier', 255)->change();

            $table->string('kontak_person', 255)
                ->nullable()
                ->change();

            $table->string('email', 255)
                ->nullable()
                ->change();

            $table->string('telepon', 255)
                ->nullable()
                ->change();

            $table->string('negara', 255)
                ->nullable()
                ->change();

            $table->string('provinsi', 255)
                ->nullable()
                ->change();

            $table->string('kota', 255)
                ->nullable()
                ->change();

            $table->string('kode_pos', 255)
                ->nullable()
                ->change();
        });
    }
};