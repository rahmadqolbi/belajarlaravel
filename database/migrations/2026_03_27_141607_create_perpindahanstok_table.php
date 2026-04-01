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
        Schema::create('perpindahanstok', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transfer', 50)->unique();
            $table->foreignId('outlet_asal_id')->constrained('outlet')->cascadeOnDelete();
            $table->foreignId('outlet_tujuan_id')->constrained('outlet')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('status', ['selesai', 'dibatalkan'])->default('selesai');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perpindahanstok');
    }
};
