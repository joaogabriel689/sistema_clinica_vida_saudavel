<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $table = 'planos';

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'preco_mensal',
        'max_medicos',
        'max_recepcionistas',
        'max_consultas_mes',
        'ativo',
    ];

    public function getPrecoAttribute()
    {
        return $this->attributes['preco_mensal'] ?? 0;
    }

    public function getLimiteMedicosAttribute()
    {
        return $this->attributes['max_medicos'] ?? 5;
    }

    public function getLimiteRecepcionistasAttribute()
    {
        return $this->attributes['max_recepcionistas'] ?? 5;
    }

    public function assinaturas()
    {
        return $this->hasMany(Assinatura::class);
    }
}
