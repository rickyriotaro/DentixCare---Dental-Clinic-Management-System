<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_records', 'dokter_id')) {
                $table->unsignedBigInteger('dokter_id')->nullable()->after('patient_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            if (Schema::hasColumn('medical_records', 'dokter_id')) {
                $table->dropColumn('dokter_id');
            }
        });
    }
};
