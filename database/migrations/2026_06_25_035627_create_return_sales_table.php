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
        Schema::create('return_sales', function (Blueprint $table) {

            $table->id();

            $table->string('kode_retur')->unique();

            $table->foreignId('sale_id')
                ->constrained('sales')
                ->onDelete('cascade');

            $table->date('tanggal');

            $table->decimal('total_retur',15,2)
                ->default(0);

            $table->text('keterangan')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_sales');
    }
};