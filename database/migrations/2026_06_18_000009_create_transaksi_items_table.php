<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksis')->cascadeOnDelete();
            $table->foreignId('varian_produk_id')->constrained('varian_produks');
            $table->foreignId('rak_id')->nullable()->constrained('raks')->nullOnDelete(); // rak tujuan/asal
            $table->string('nomor_batch')->nullable();    // nomor batch produksi
            $table->date('tanggal_produksi')->nullable();
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->integer('qty');
            $table->string('kondisi')->default('baik');  // baik, rusak, cacat
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_items');
    }
};
