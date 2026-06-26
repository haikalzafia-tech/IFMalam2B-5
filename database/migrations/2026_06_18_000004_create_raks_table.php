<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_id')->constrained('zonas')->cascadeOnDelete();
            $table->string('kode_rak');
            $table->string('nama_rak');
            $table->integer('jumlah_baris');      // baris rak (row)
            $table->integer('jumlah_kolom');      // kolom rak (column)
            $table->integer('kapasitas_total');   // total slot/unit yang bisa ditampung
            $table->integer('kapasitas_terpakai')->default(0);
            $table->enum('status', ['aktif', 'penuh', 'nonaktif'])->default('aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['zona_id', 'kode_rak']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raks');
    }
};
