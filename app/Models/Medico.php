<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';

    protected $fillable = [
        'nome',
        'crm',
        'telefone',
        'clinica_id',
        'user_id',
        'especialidade_id',
        'horario_inicio',
        'horario_fim'
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}