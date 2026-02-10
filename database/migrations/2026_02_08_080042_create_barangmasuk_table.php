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
    $table->id();
    $table->date('tanggal');
    // kolom FK dibuat manual
    $table->unsignedBigInteger('supplier_id');
    $table->unsignedBigInteger('tujuan_id')->nullable();
    $table->string('tujuan_type')->nullable();

    $table->string('no_dokumen')->nullable();
    $table->text('keterangan')->nullable();

    $table->timestamps();

    // FK ditulis manual (AMAN UNTUK SQLITE)
    $table->foreign('supplier_id')->references('id')->on('supplier');
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
