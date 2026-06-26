<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('varian_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->cascadeOnDelete();
            $table->foreignId('rak_id')->nullable()->constrained('raks')->nullOnDelete(); // lokasi di rak
            $table->string('nomor_sku')->unique();
            $table->string('nama_varian');
            $table->string('gambar_varian')->nullable();
            $table->string('berat')->nullable();  // berat per unit, misal: "500gr", "1kg"
            $table->string('dimensi')->nullable(); // ukuran fisik, misal: "30x20x10cm"
            $table->integer('stok_varian')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('varian_produks');
    }
};
