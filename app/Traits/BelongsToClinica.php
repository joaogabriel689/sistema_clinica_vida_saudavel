<?php

namespace App\Traits;

use App\Models\Clinica;
use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToClinica
{
    /**
     * Boot the trait and register the global scope and creating event listener.
     */
    protected static function bootBelongsToClinica(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (Auth::check() && Auth::user() && Auth::user()->clinica_id && !isset($model->clinica_id)) {
                $model->clinica_id = Auth::user()->clinica_id;
            }
        });
    }

    /**
     * Get the clinic associated with the model.
     */
    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class, 'clinica_id');
    }
}
