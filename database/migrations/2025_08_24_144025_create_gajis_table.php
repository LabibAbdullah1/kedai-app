<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pegawai
            $table->integer('total_hadir')->default(0); // Jumlah kehadiran
            $table->integer('total_jam_kerja')->default(0); // Dalam menit
            $table->integer('total_lembur')->default(0); // Dalam menit
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->decimal('uang_lembur', 15, 2)->default(0);
            $table->decimal('total_gaji', 15, 2)->default(0);
            $table->date('periode_gaji');
            $table->enum('status', ['belum_dibayar', 'dibayar'])->default('belum_dibayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
