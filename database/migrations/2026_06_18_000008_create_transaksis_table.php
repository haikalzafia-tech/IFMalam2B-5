<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->enum('jenis_transaksi', ['pemasukan', 'pengeluaran']);
            $table->foreignId('gudang_id')->constrained('gudangs');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->integer('jumlah_barang');
            $table->string('nomor_po')->nullable();       // nomor Purchase Order
            $table->string('nomor_surat_jalan')->nullable();
            $table->date('tanggal_transaksi');
            $table->date('tanggal_kadaluarsa_po')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->string('petugas');                    // nama/id petugas gudang
            $table->string('penerima')->nullable();       // nama penerima (untuk pengeluaran)
            $table->string('tujuan')->nullable();         // tujuan pengiriman (untuk pengeluaran)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
