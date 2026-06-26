<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kartu_stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('varian_produk_id')->constrained('varian_produks')->cascadeOnDelete();
            $table->foreignId('gudang_id')->constrained('gudangs');
            $table->foreignId('rak_id')->nullable()->constrained('raks')->nullOnDelete();
            $table->string('nomor_transaksi')->nullable();
            $table->enum('jenis_transaksi', ['in', 'out', 'adjustment', 'retur', 'transfer']);
            $table->string('nomor_batch')->nullable();
            $table->integer('jumlah_masuk')->default(0);
            $table->integer('jumlah_keluar')->default(0);
            $table->integer('stok_akhir');
            $table->string('petugas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kartu_stoks');
    }
};
