<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_opname')->unique();
            $table->foreignId('gudang_id')->constrained('gudangs');
            $table->date('tanggal_opname');
            $table->enum('status', ['draft', 'berlangsung', 'selesai'])->default('draft');
            $table->string('petugas');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('stok_opname_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_opname_id')->constrained('stok_opnames')->cascadeOnDelete();
            $table->foreignId('varian_produk_id')->constrained('varian_produks');
            $table->foreignId('rak_id')->nullable()->constrained('raks')->nullOnDelete();
            $table->integer('stok_sistem');       // stok menurut sistem
            $table->integer('stok_fisik');        // stok hasil hitung fisik
            $table->integer('selisih')->virtualAs('stok_fisik - stok_sistem');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_opname_items');
        Schema::dropIfExists('stok_opnames');
    }
};
