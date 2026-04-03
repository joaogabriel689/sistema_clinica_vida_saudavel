<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\AuditoriaObserver;
use App\Models\AuditoriaModel;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $modelsPath = app_path('Models');

        foreach (File::allFiles($modelsPath) as $file) {

            $class = 'App\\Models\\' . $file->getFilenameWithoutExtension();

            if (class_exists($class)) {

                // Evita aplicar em classes que não são models
                if (is_subclass_of($class, Model::class)) {
                    $class::observe(AuditoriaObserver::class);
                }
            }
        }
    }
}
