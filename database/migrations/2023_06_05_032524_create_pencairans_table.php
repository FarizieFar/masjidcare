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
        Schema::create('pencairans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('masjid_id');
            $table->integer('nominal');
            $table->string('status');
            $table->foreign('masjid_id')->references('id')->on('masjids');
            $table->dateTime('tanggal');
            $table->string('pdf_laporan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencairans');
    }
};
