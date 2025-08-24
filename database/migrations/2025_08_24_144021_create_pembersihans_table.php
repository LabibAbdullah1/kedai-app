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
        Schema::create('pembersihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meja_id')->constrained('meja')->onDelete('cascade');
            $table->foreignId('pelayan_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['belum_dibersihkan', 'sudah_dibersihkan'])->default('belum_dibersihkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembersihans');
    }
};
