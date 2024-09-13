<?php

namespace App\Providers;

use App\Repositories\NoteRepository;
use App\Services\NoteService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
          // Registrar el repositorio
          $this->app->singleton(NoteRepository::class, function ($app) {
            return new NoteRepository();
        });

        // Registrar el servicio
        $this->app->singleton(NoteService::class, function ($app) {
            return new NoteService($app->make(NoteRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
