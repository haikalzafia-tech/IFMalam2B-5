<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_produk_id')->nullable()->constrained('kategori_produks')->nullOnDelete();
            $table->string('kode_produk')->unique();
            $table->string('nama_produk');
            $table->string('merek')->nullable();
            $table->string('satuan');             // pcs, kg, liter, karton, dll
            $table->text('deskripsi_produk')->nullable();
            $table->integer('stok_minimum');      // batas minimum stok (untuk alert)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
