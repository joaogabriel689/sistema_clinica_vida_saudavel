<?php
namespace App\Observers;

use App\Models\User;
use App\Models\AuditoriaModel;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user): void
    {
        AuditoriaModel::create([
            'user_id' => Auth::id(),
            'tipo_user' => Auth::user()->role ?? null,
            'acao' => 'CREATE',

            'entidade' => 'users',
            'entidade_id' => $user->id,

            'dados_anteriores' => null,
            'dados_novos' => $user->getAttributes(),

            'rota' => request()->path(),
            'metodo' => request()->method(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data_hora' => now(),
        ]);
    }

    public function updated(User $user): void
    {
        AuditoriaModel::create([
            'user_id' => Auth::id(),
            'tipo_user' => Auth::user()->role ?? null,
            'acao' => 'UPDATE',

            'entidade' => 'users',
            'entidade_id' => $user->id,

            'dados_anteriores' => $user->getOriginal(),
            'dados_novos' => $user->getChanges(),

            'rota' => request()->path(),
            'metodo' => request()->method(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data_hora' => now(),
        ]);
    }

    public function deleted(User $user): void
    {
        AuditoriaModel::create([
            'user_id' => Auth::id(),
            'tipo_user' => Auth::user()->role ?? null,
            'acao' => 'DELETE',

            'entidade' => 'users',
            'entidade_id' => $user->id,

            'dados_anteriores' => $user->getOriginal(),
            'dados_novos' => null,

            'rota' => request()->path(),
            'metodo' => request()->method(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data_hora' => now(),
        ]);
    }
}