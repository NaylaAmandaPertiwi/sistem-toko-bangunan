<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_details', function (Blueprint $table) {

            $table->foreignId('sale_detail_id')
                  ->after('return_sale_id')
                  ->constrained('sale_details')
                  ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('return_details', function (Blueprint $table) {

            $table->dropForeign(['sale_detail_id']);

            $table->dropColumn('sale_detail_id');

        });
    }
};