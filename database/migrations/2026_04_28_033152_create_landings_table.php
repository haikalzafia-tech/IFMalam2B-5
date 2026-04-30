<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landings', function (Blueprint $table) {
            $table->id();
            // Nama bagian (misal: 'hero', 'about', 'feature_1')
            $table->string('section_key')->unique();

            // Konten teks
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            // Aset visual (bisa simpan nama file model 3D atau gambar)
            $table->string('image_content')->nullable();

            // Tombol Call to Action (CTA)
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();

            // Status aktif
            $table->boolean('is_visible')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landings');
    }
};
