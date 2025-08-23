<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('waiter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('table_id')->nullable()->constrained('tables')->onDelete('set null');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', ['pending', 'diproses', 'siap', 'selesai', 'dibatalkan'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
