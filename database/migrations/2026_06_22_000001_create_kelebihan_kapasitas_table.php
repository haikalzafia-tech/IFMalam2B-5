<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelebihan_kapasitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_item_id')->constrained('transaksi_items')->cascadeOnDelete();
            $table->foreignId('varian_produk_id')->constrained('varian_produks');
            $table->foreignId('rak_id')->constrained('raks'); // rak yang dituju semula (sudah penuh)
            $table->integer('qty_muat');     // qty yang berhasil masuk ke rak (sisa kapasitas)
            $table->integer('qty_lebih');    // qty yang kelebihan, belum punya lokasi
            $table->enum('status', ['menunggu', 'dipindah_rak', 'diretur', 'dibatalkan'])->default('menunggu');
            $table->foreignId('rak_tujuan_id')->nullable()->constrained('raks')->nullOnDelete(); // diisi jika dipindah_rak
            $table->foreignId('transaksi_retur_id')->nullable()->constrained('transaksi_returs')->nullOnDelete(); // diisi jika diretur
            $table->string('diselesaikan_oleh')->nullable();
            $table->timestamp('diselesaikan_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelebihan_kapasitas');
    }
};
