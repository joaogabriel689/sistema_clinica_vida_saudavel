<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClinica;

class Convenio extends Model
{
    use BelongsToClinica;

    protected $table = 'convenios';

    protected $fillable = [
        'nome',
        'percentual_desconto',
        'codigo',
        'clinica_id'
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

    public function pacientes()
    {
        return $this->belongsToMany(
            Paciente::class,
            'convenio_paciente'
        );
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}