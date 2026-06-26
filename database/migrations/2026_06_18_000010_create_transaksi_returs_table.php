<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_returs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_retur')->unique();
            $table->foreignId('transaksi_id')->constrained('transaksis'); // transaksi asal
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->foreignId('gudang_id')->constrained('gudangs');
            $table->enum('jenis_retur', ['retur_masuk', 'retur_keluar']);
            // retur_masuk = barang dikembalikan ke supplier
            // retur_keluar = barang dikembalikan dari penerima ke gudang
            $table->date('tanggal_retur');
            $table->enum('status', ['pending', 'diproses', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('alasan_retur');
            $table->string('petugas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_returs');
    }
};
