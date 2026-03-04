<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paciente extends Model
{
    protected $table = 'pacientes';
    protected $fillable = ['id', 'nome', 'cpf', 'telefone', 'endereco', 'data_nascimento'];
}
