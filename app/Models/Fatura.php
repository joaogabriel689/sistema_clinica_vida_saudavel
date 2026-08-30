<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $table = 'faturas';

    protected $fillable = [
        'assinatura_id',
        'gateway_id',
        'valor',
        'status',
        'data_vencimento',
        'data_pagamento',
        'pdf_url',
        'pix_qr_code',
    ];

    public function assinatura()
    {
        return $this->belongsTo(Assinatura::class);
    }
}
