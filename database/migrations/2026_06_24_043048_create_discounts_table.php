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
        Schema::create('discounts', function (Blueprint $table) {

            $table->id();

            $table->string('nama_diskon');

            $table->decimal('minimal_belanja',15,0);

            $table->integer('persentase_diskon');

            $table->enum(
                'status',
                [
                    'Aktif',
                    'Nonaktif'
                ]
            )->default('Aktif');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
