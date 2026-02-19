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
        Schema::create('penjualan_detail', function (Blueprint $table) {
                $table->id();
               $table->foreignId('penjualan_id')
      ->constrained('penjualan')
      ->onDelete('cascade');
                $table->foreignId('produk_id')
            ->constrained('produk')
            ->onDelete('cascade');

                $table->integer('qty');
                $table->decimal('harga', 15, 2); // harga saat transaksi
                $table->decimal('subtotal', 15, 2);
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail');
    }
};
