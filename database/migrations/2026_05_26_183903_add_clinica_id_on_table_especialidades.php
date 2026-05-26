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
        Schema::table("especialidades", function (Blueprint $table) {
            $table->unsignedBigInteger('clinica_id')->nullable();
            $table->foreign('clinica_id')->references('id')->on('clinicas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("especialidades", function (Blueprint $table) {
            $table->dropForeign('especialidades_clinica_id_foreign');
            $table->dropColumn('clinica_id');
        });
    }
};
