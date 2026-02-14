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
        Schema::create('visit_reports', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id')->nullable();
    $table->date('from_date')->nullable();
    $table->date('to_date')->nullable();
    $table->string('nama_pasien')->nullable();
    $table->string('keluhan')->nullable();
    $table->string('riwayat_penyakit')->nullable();
    $table->integer('total')->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_reports');
    }
};
