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
        Schema::create('barangmasukdetail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_masuk_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('qty');
            $table->decimal('harga', 15, 2);
            $table->timestamps();
            // barang_masuk_id harus cocok dengan id yang ada di tabel barangmasuk
            $table->foreign('barang_masuk_id')
            ->references('id')
            ->on('barangmasuk')
            ->onDelete('cascade');
            // Kalau data di tabel barangmasuk dihapus
            // → semua detail yang terhubung ikut terhapus otomatis.
            $table->foreign('barang_id')
            ->references('id')
            ->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangmasukdetail');
    }
};
