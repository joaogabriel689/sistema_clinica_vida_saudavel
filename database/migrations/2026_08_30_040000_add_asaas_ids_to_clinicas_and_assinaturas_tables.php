<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('clinicas') && !Schema::hasColumn('clinicas', 'asaas_customer_id')) {
            Schema::table('clinicas', function (Blueprint $table) {
                $table->string('asaas_customer_id')->nullable()->after('custom_domain');
            });
        }

        if (Schema::hasTable('assinaturas') && !Schema::hasColumn('assinaturas', 'asaas_subscription_id')) {
            Schema::table('assinaturas', function (Blueprint $table) {
                $table->string('asaas_subscription_id')->nullable()->after('gateway');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('clinicas') && Schema::hasColumn('clinicas', 'asaas_customer_id')) {
            Schema::table('clinicas', function (Blueprint $table) {
                $table->dropColumn('asaas_customer_id');
            });
        }

        if (Schema::hasTable('assinaturas') && Schema::hasColumn('assinaturas', 'asaas_subscription_id')) {
            Schema::table('assinaturas', function (Blueprint $table) {
                $table->dropColumn('asaas_subscription_id');
            });
        }
    }
};
