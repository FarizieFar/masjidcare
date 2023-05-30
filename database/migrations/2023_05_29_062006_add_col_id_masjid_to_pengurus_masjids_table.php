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
        Schema::table('pengurus_masjids', function (Blueprint $table) {
            $table->unsignedBigInteger('id_masjid')->unique()->index()->after('password');
            $table->foreign('id_masjid')->references('id')->on('masjids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengurus_masjids', function (Blueprint $table) {
            //
        });
    }
};
