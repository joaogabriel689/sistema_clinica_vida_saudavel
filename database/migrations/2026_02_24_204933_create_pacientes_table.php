<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        /*
        |--------------------------------------------------------------------------
        | CLINICAS
        |--------------------------------------------------------------------------
        */

        Schema::create('clinicas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('endereco');
            $table->string('telefone');
            $table->string('cnpj')->unique();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | VINCULO USER -> CLINICA
        |--------------------------------------------------------------------------
        */

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('clinica_id')->nullable()->constrained()->cascadeOnDelete();
        });

        /*
        |--------------------------------------------------------------------------
        | ESPECIALIDADES
        |--------------------------------------------------------------------------
        */

        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | PACIENTES
        |--------------------------------------------------------------------------
        */

        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf');
            $table->string('telefone');
            $table->string('endereco');
            $table->date('data_nascimento');

            $table->foreignId('clinica_id')->constrained()->cascadeOnDelete();

            $table->unique(['cpf', 'clinica_id']);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | MEDICOS
        |--------------------------------------------------------------------------
        */

        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('crm');
            $table->string('telefone');

            $table->foreignId('clinica_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('especialidade_id')->constrained()->cascadeOnDelete();

            $table->time('horario_inicio');
            $table->time('horario_fim');

            $table->unique(['crm', 'clinica_id']);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | CONVENIOS
        |--------------------------------------------------------------------------
        */

        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->decimal('percentual_desconto', 5, 2);
            $table->string('codigo');

            $table->foreignId('clinica_id')->constrained()->cascadeOnDelete();

            $table->unique(['codigo', 'clinica_id']);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | CONSULTAS
        |--------------------------------------------------------------------------
        */

        Schema::create('consultas', function (Blueprint $table) {
            $table->id();

            $table->dateTime('data_hora_inicio');
            $table->dateTime('data_hora_fim')->nullable();
            $table->decimal('valor', 8, 2);

            $table->foreignId('clinica_id')->constrained()->cascadeOnDelete();

            $table->foreignId('medico_id')->constrained()->cascadeOnDelete();
            $table->foreignId('paciente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('convenio_id')->nullable()->constrained()->nullOnDelete();

            $table->string('status')->default('agendada');
            $table->text('observacoes')->nullable();
            $table->boolean('pago')->default(false);

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | PIVOT: PACIENTE_CONVENIO
        |--------------------------------------------------------------------------
        */

        Schema::create('convenio_paciente', function (Blueprint $table) {
            $table->id();

            $table->foreignId('clinica_id')->constrained()->cascadeOnDelete();
            $table->foreignId('paciente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('convenio_id')->constrained()->cascadeOnDelete();

            $table->unique(['paciente_id', 'convenio_id', 'clinica_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('convenio_paciente');
        Schema::dropIfExists('consultas');
        Schema::dropIfExists('convenios');
        Schema::dropIfExists('medicos');
        Schema::dropIfExists('pacientes');
        Schema::dropIfExists('especialidades');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['clinica_id']);
            $table->dropColumn('clinica_id');
        });

        Schema::dropIfExists('clinicas');
        Schema::dropIfExists('users');
    }
};