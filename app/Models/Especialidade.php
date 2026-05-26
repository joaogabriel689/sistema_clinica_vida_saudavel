<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClinica;

class Especialidade extends Model
{
    use BelongsToClinica;
    protected $table = 'especialidades';

    protected $fillable = [
        'nome'
    ];

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }
}