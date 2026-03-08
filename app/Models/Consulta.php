<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';

    protected $fillable = [
        'data_hora_inicio',
        'data_hora_fim',
        'valor',
        'medico_id',
        'paciente_id',
        'convenio_id',
        'status',
        'observacoes',
        'pago'
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class);
    }
}