<?php

namespace App\Models;

use App\Traits\BelongsToClinica;
use Illuminate\Database\Eloquent\Model;

class WhatsappInstancia extends Model
{
    use BelongsToClinica;

    protected $table = 'whatsapp_instancias';

    protected $fillable = [
        'clinica_id',
        'instance_id',
        'token',
        'client_token',
        'status',
        'qr_code',
    ];
}
