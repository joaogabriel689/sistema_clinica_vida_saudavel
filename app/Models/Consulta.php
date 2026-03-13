<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'especialidade_id',
        'convenio_id',
        'data_hora_inicio',
        'data_hora_fim',
        'valor',
        'status',
        'pagamento_confirmado'
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

}