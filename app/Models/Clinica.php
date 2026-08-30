<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Clinica extends Model
{
    protected $table = 'clinicas';

    protected $fillable = [
        'nome',
        'endereco',
        'telefone',
        'cnpj',
        'slug',
        'custom_domain',
        'cor_primaria',
        'logo_url',
        'banner_url',
        'descricao',
        'user_id',
        'asaas_customer_id'
    ];

    public function recepcionistas()
    {
        return $this->hasMany(User::class)->where('role', 'recepcionista');
    }

    protected static function booted()
    {
        static::creating(function ($clinica) {
            if (empty($clinica->slug) && !empty($clinica->nome)) {
                $baseSlug = Str::slug($clinica->nome);
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $clinica->slug = $slug;
            }
        });
    }

    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }

    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pacientes()
    {
        return $this->hasMany(Paciente::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}