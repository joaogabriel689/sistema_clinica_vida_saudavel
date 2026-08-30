<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clinicas', function (Blueprint $table) {
            if (!Schema::hasColumn('clinicas', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('cnpj');
            }
            if (!Schema::hasColumn('clinicas', 'custom_domain')) {
                $table->string('custom_domain')->nullable()->unique()->after('slug');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clinicas', function (Blueprint $table) {
            if (Schema::hasColumn('clinicas', 'custom_domain')) {
                $table->dropColumn('custom_domain');
            }
            if (Schema::hasColumn('clinicas', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
