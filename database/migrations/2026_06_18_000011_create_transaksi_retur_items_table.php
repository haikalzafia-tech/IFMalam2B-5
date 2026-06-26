<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_retur_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_retur_id')->constrained('transaksi_returs')->cascadeOnDelete();
            $table->foreignId('varian_produk_id')->constrained('varian_produks');
            $table->foreignId('transaksi_item_id')->nullable()->constrained('transaksi_items')->nullOnDelete(); // item asal
            $table->string('nomor_batch')->nullable();
            $table->integer('qty_retur');
            $table->enum('kondisi_barang', ['baik', 'rusak', 'cacat', 'kadaluarsa']);
            $table->text('keterangan_kondisi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_retur_items');
    }
};
