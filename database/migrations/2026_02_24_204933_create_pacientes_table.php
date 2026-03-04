<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. PACIENTES (Independente)
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id(); // Simplificado: id padrão Laravel
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('telefone');
            $table->string('endereco');
            $table->date('data_nascimento');
            $table->timestamps();
        });

        // 2. ESPECIALIDADES (Precisa vir antes de Medicos)
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->timestamps();
        });

        // 3. CLINICAS (Precisa vir antes de Medicos e Convenios)
        Schema::create('clinicas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('endereco');
            $table->string('telefone');
            $table->string("cnpj")->unique();
            // Referência ao dono da clínica (User)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 4. MEDICOS (Agora pode referenciar Especialidade e Clinica)
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('crm')->unique();
            $table->string('telefone');
            $table->foreignId('clinica_id')->constrained('clinicas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('especialidade_id')->constrained('especialidades')->onDelete('cascade');
            $table->time("horario_inicio"); // Alterado para 'time' para representar hora
            $table->time("horario_fim");    // Alterado para 'time'
            $table->timestamps();
        });

        // 5. CONVENIOS
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('percentual_desconto', 5, 2);
            $table->string('codigo')->unique();
            $table->foreignId('clinica_id')->constrained('clinicas')->onDelete('cascade');
            $table->timestamps();
        });

        // 6. CONSULTAS (A "entidade" que une tudo)
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_hora_inicio'); 
            $table->dateTime('data_hora_fim')->nullable();
            $table->decimal('valor', 8, 2);
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('convenio_id')->nullable()->constrained('convenios')->onDelete('set null');
            $table->string('status')->default('agendada');
            $table->text('observacoes')->nullable();
            $table->boolean('pago')->default(false);
            $table->timestamps();
        });

        // 7. TABELA PIVÔ: PACIENTE_CONVENIO (Conforme Estudo de Caso Parte 2)
        // Um paciente pode ter vários convênios 
        Schema::create('convenio_paciente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained()->onDelete('cascade');
            $table->foreignId('convenio_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Ordem inversa para o drop (Evita erro de constraint)
        Schema::dropIfExists('convenio_paciente');
        Schema::dropIfExists('consultas');
        Schema::dropIfExists('convenios');
        Schema::dropIfExists('medicos');
        Schema::dropIfExists('clinicas');
        Schema::dropIfExists('especialidades');
        Schema::dropIfExists('pacientes');
    }
};