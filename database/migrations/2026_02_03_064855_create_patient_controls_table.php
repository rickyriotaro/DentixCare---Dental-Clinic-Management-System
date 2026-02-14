<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_controls', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medical_record_id');
            $table->unsignedBigInteger('dokter_id');

            $table->date('tanggal_kontrol');
            $table->time('jam_kontrol')->nullable();

            $table->string('status')->default('terjadwal'); // terjadwal | selesai | batal
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('cascade');
            $table->foreign('dokter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_controls');
    }
};
