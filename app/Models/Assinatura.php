<?php

namespace App\Models;

use App\Traits\BelongsToClinica;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use BelongsToClinica;

    protected $table = 'assinaturas';

    protected $fillable = [
        'clinica_id',
        'plano_id',
        'status',
        'trial_ends_at',
        'proxima_cobranca',
        'gateway',
        'subscription_gateway_id',
        'asaas_subscription_id',
    ];

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }
}
