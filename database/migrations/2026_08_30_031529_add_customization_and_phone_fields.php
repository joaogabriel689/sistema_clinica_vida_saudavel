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
        Schema::table('clinicas', function (Blueprint $table) {
            if (!Schema::hasColumn('clinicas', 'cor_primaria')) {
                $table->string('cor_primaria')->nullable()->default('#059669')->after('custom_domain');
            }
            if (!Schema::hasColumn('clinicas', 'logo_url')) {
                $table->string('logo_url')->nullable()->after('cor_primaria');
            }
            if (!Schema::hasColumn('clinicas', 'banner_url')) {
                $table->string('banner_url')->nullable()->after('logo_url');
            }
            if (!Schema::hasColumn('clinicas', 'descricao')) {
                $table->text('descricao')->nullable()->after('banner_url');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'telefone')) {
                $table->string('telefone')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinicas', function (Blueprint $table) {
            $table->dropColumn(['cor_primaria', 'logo_url', 'banner_url', 'descricao']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefone']);
        });
    }
};
