<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaModel extends Model
{
    protected $table = 'system_log';

    protected $fillable = [
        'user_id',
        'tipo_user',
        'acao',
        'entidade',
        'entidade_id',
        'rota',
        'metodo',
        'dados_anteriores',
        'dados_novos',
        'ip',
        'user_agent',
        'data_hora',

    ];
    protected $casts = [
        'dados_anteriores' => 'array',
        'dados_novos' => 'array',
        'data_hora' => 'datetime',
    ];
}
