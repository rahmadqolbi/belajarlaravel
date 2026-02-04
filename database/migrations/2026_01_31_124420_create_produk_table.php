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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
          $table->foreignId('kategori_id')
            ->nullable()
            ->constrained('kategori')
            ->restrictOnDelete();
            $table->string('kode');
            $table->string('nama_barang');
            $table->string('deskripsi')->nullable();
            $table->integer('stok');
            $table->decimal('harga', 15,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
