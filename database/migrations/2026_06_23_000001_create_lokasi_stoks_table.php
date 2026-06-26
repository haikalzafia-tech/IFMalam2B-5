<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi_stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('varian_produk_id')->constrained('varian_produks')->cascadeOnDelete();
            $table->foreignId('rak_id')->constrained('raks')->cascadeOnDelete();
            $table->integer('qty')->default(0);
            $table->timestamps();

            // Satu varian hanya boleh punya SATU baris per rak (supaya tidak duplikat)
            $table->unique(['varian_produk_id', 'rak_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_stoks');
    }
};
