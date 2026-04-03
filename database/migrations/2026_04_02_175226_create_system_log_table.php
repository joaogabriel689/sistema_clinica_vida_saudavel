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
        Schema::create('system_log', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tipo_user');
            $table->string('acao');
            $table->string('entidade');
            $table->unsignedBigInteger('entidade_id')->nullable();
            $table->string('rota')->nullable();
            $table->string('metodo')->nullable();
            $table->text('dados_anteriores')->nullable();
            $table->text('dados_novos')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->datetime('data_hora')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_log');
    }
};
