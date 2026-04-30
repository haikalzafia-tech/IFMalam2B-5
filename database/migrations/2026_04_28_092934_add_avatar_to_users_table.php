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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom avatar untuk foto profil
            $table->string('avatar')->nullable()->after('email');

            // Menambahkan kolom role (jika sebelumnya belum ada)
            // Kita gunakan enum agar pilihannya terbatas hanya admin atau manager
            $table->enum('role', ['admin', 'manager'])->default('manager')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['avatar', 'role']);
        });
    }
};