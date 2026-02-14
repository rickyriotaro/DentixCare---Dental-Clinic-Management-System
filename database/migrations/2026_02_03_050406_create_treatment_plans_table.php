<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('treatment_plans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medical_record_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('dokter_id'); // user dokter

            $table->date('tanggal_rencana')->nullable();
            $table->string('judul', 150)->nullable();
            $table->text('rencana')->nullable();     // isi rencana tindakan
            $table->text('catatan')->nullable();     // catatan tambahan
            $table->enum('status', ['draft','selesai'])->default('draft');

            $table->timestamps();

            // FK (sesuaikan nama tabel users kalau beda)
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->cascadeOnDelete();
            $table->foreign('patient_id')->references('id')->on('patients')->cascadeOnDelete();
            $table->foreign('dokter_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_plans');
    }
};
