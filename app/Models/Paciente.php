<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'endereco',
        'data_nascimento'
    ];

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function convenios()
    {
        return $this->belongsToMany(
            Convenio::class,
            'convenio_paciente'
        );
    }
}