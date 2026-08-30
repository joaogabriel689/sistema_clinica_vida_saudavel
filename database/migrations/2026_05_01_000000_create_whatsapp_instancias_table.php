<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_instancias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_id')->constrained('clinicas')->onDelete('cascade');
            $table->string('instance_id')->nullable();
            $table->string('token')->nullable();
            $table->string('client_token')->nullable();
            $table->enum('status', ['conectado', 'desconectado', 'aguardando_qr'])->default('desconectado');
            $table->text('qr_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_instancias');
    }
};
