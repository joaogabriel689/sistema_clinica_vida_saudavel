<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';
    protected $fillable = ['id', 'nome', 'crm', 'telefone', 'clinica_id', 'user_id', 'especialidade_id', 'horario_inicio', 'horario_fim'];
}
