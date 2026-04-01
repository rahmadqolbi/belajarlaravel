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
        Schema::create('stok_outlet', function (Blueprint $table) {
        $table->id();
        $table->foreignId('produk_id')->constrained('produk')->cascadeOnDelete();
        $table->foreignId('outlet_id')->constrained('outlet')->cascadeOnDelete();
        $table->unsignedInteger('stok')->default(0);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_outlet');
    }
};
