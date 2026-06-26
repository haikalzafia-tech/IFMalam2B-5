<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zonas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gudang_id')->constrained('gudangs')->cascadeOnDelete();
            $table->string('kode_zona');
            $table->string('nama_zona');
            // Contoh zona: A (elektronik), B (makanan), C (bahan berbahaya), dll
            $table->enum('jenis_zona', ['reguler', 'dingin', 'berbahaya', 'karantina', 'ekspedisi'])->default('reguler');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->unique(['gudang_id', 'kode_zona']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zonas');
    }
};
