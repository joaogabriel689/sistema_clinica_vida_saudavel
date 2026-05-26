<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClinica;

class Consulta extends Model
{
    use BelongsToClinica;

    protected $fillable = [
        'paciente_id',
        'clinica_id',
        'medico_id',
        'convenio_id',
        'data_hora_inicio',
        'data_hora_fim',
        'valor',
        'status',
        'pago',

    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class);
    }
    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }

}