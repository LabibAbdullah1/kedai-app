<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Informasi dasar pengguna
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // Role user (admin, waiter, koki, kasir, cleaning)
            $table->enum('role', ['admin', 'waiter', 'koki', 'cleaning'])->default('waiter');
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->decimal('lembur_per_jam', 15, 2)->default(0);
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            // Data tambahan
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Untuk keperluan Laravel Auth
            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
