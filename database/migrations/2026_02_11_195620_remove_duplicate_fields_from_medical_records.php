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
        Schema::table('medical_records', function (Blueprint $table) {
            // Hapus kolom duplikat karena data sudah ada di tabel patients
            $table->dropColumn(['nama_pasien', 'alamat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // Restore kolom jika rollback
            $table->string('nama_pasien')->nullable();
            $table->text('alamat')->nullable();
        });
    }
};
