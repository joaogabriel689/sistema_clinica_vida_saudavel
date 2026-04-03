<?php


namespace App\Observers;

use App\Models\AuditoriaModel;
use Illuminate\Support\Facades\Auth;

class AuditoriaObserver
{
    public function created($model): void
    {
        $this->auditar('CREATE', $model, null, $model->getAttributes());
    }

    public function updated($model): void
    {
        $this->auditar('UPDATE', $model, $model->getOriginal(), $model->getChanges());
    }

    public function deleted($model): void
    {
        $this->auditar('DELETE', $model, $model->getOriginal(), null);
    }

    private function auditar($acao, $model, $antes, $depois)
    {
        // Evita loop infinito (não auditar a própria auditoria)
        if ($model instanceof AuditoriaModel) {
            return;
        }

        AuditoriaModel::create([
            'user_id' => Auth::id() ?? null,
            'tipo_user' => Auth::user()->role ?? null,

            'acao' => $acao,

            'entidade' => class_basename($model),
            'entidade_id' => $model->id ?? null,

            'dados_anteriores' => $antes,
            'dados_novos' => $depois,

            'rota' => request()?->path(),
            'metodo' => request()?->method(),

            'ip' => request()?->ip(),
            'user_agent' => request()?->userAgent(),

            'data_hora' => now(),
        ]);
    }
}