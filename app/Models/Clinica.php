<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
    protected $table = 'clinicas';

    protected $fillable = [
        'nome',
        'endereco',
        'telefone',
        'cnpj',
        'user_id'
    ];

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }

    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }
    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}