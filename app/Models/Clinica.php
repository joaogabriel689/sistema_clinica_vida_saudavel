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
        'user_id',
    ];

}
