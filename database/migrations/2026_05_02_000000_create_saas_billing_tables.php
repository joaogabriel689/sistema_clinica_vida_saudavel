<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug')->unique();
            $table->text('descricao')->nullable();
            $table->decimal('preco_mensal', 10, 2);
            $table->integer('max_medicos')->default(1);
            $table->integer('max_recepcionistas')->default(2);
            $table->integer('max_consultas_mes')->default(100);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_id')->constrained('clinicas')->onDelete('cascade');
            $table->foreignId('plano_id')->constrained('planos')->onDelete('cascade');
            $table->enum('status', ['trial', 'ativa', 'inadimplente', 'cancelada'])->default('trial');
            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('proxima_cobranca')->nullable();
            $table->string('gateway')->default('asaas');
            $table->string('subscription_gateway_id')->nullable();
            $table->timestamps();
        });

        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assinatura_id')->constrained('assinaturas')->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->enum('status', ['pendente', 'paga', 'vencida', 'cancelada'])->default('pendente');
            $table->dateTime('data_vencimento');
            $table->dateTime('data_pagamento')->nullable();
            $table->string('pdf_url')->nullable();
            $table->string('pix_qr_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faturas');
        Schema::dropIfExists('assinaturas');
        Schema::dropIfExists('planos');
    }
};
