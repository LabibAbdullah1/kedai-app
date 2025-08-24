<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_meja')->unique();
            $table->integer('kapasitas');
            $table->enum('status', ['ready', 'terisi', 'dibooking', 'belum_dibersihkan'])->default('ready');
            $table->dateTime('booking_mulai')->nullable();
            $table->dateTime('booking_selesai')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mejas');
    }
};
