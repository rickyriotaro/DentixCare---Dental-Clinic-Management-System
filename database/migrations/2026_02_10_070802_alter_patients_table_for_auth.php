<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {

            // kolom auth (AMAN)
            if (!Schema::hasColumn('patients', 'email')) {
                $table->string('email')->unique()->after('no_hp');
            }

            if (!Schema::hasColumn('patients', 'username')) {
                $table->string('username')->unique()->after('email');
            }

            if (!Schema::hasColumn('patients', 'password')) {
                $table->string('password')->after('username');
            }

            if (!Schema::hasColumn('patients', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }

            // ❗ KELUHAN TIDAK DIHAPUS
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {

            $table->dropColumn([
                'email',
                'username',
                'password',
                'last_login_at'
            ]);

            // ❗ keluhan tetap aman
        });
    }
};
