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
      Schema::create('barangmasuk', function (Blueprint $table) {
            // === IDENTITAS ===
            $table->id();
            $table->date('tanggal');

            // === RELASI ===
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('tujuan_id')->nullable();
            $table->string('tujuan_type')->nullable();

            // === INFORMASI DOKUMEN ===
            $table->string('no_dokumen')->nullable()->unique();
            $table->text('keterangan')->nullable();

            // === STATUS (INI SAJA YANG PERLU DITAMBAH) ===
            $table->enum('status', ['DRAFT', 'APPROVED'])->default('DRAFT');
            // DRAFT   = Bisa edit/hapus, stok belum masuk
            // APPROVED = Stok sudah masuk, tidak bisa edit sembarangan

            // === DEFAULT LARAVEL ===
            $table->timestamps();

            // === INDEX ===
            $table->index(['tanggal', 'status']);

            // === FOREIGN KEY ===
            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('supplier')
                  ->onDelete('restrict');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangmasuk');
    }
};
