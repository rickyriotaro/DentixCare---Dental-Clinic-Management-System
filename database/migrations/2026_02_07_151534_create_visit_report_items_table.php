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
        Schema::create('visit_report_items', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('visit_report_id');
    $table->unsignedBigInteger('medical_record_id')->nullable();

    $table->string('no_rm')->nullable();
    $table->string('nama_pasien')->nullable();
    $table->string('alamat')->nullable();
    $table->date('tanggal_masuk')->nullable();
    $table->string('keluhan')->nullable();
    $table->string('alergi')->nullable();
    $table->string('riwayat_penyakit')->nullable();
    $table->text('rencana_perawatan')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_report_items');
    }
};
