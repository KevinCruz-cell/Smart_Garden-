<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// IMPORTAR MODELOS (AQUÍ ESTABA EL ERROR)
use App\Models\Cultivo;
use App\Models\Siembra;
use App\Models\Cosecha;
use App\Models\User;

// OBSERVER
use App\Observers\AuditoriaObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Activar auditoría
        Cultivo::observe(AuditoriaObserver::class);
        Siembra::observe(AuditoriaObserver::class);
        Cosecha::observe(AuditoriaObserver::class);
        User::observe(AuditoriaObserver::class);
    }
}
