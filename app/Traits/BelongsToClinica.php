<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToClinica
{
    protected static function bootBelongsToClinica()
    {
        // Filtra automaticamente pela clínica
        static::addGlobalScope('clinica', function (Builder $builder) {

            if (auth()->check()) {
                $builder->where(
                    'clinica_id',
                    auth()->user()->clinica_id
                );
            }
        });

        // Preenche automaticamente ao criar
        static::creating(function ($model) {

            if (
                auth()->check() &&
                empty($model->clinica_id)
            ) {
                $model->clinica_id =
                    auth()->user()->clinica_id;
            }
        });
    }
}