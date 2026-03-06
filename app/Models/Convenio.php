<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $tablename = 'convenios';
    protected $fillable = [
        'nome',
        'clinica_id',
        'codigo',
        'percentual_desconto',
    ];
}
