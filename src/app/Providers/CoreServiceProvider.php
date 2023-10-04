<?php

namespace IBoot\Core\app\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'packages/core');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'packages/core');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
            __DIR__ . '/../../database/seeders' => database_path('seeders'),
            __DIR__ . '/../../config/core.php' => config_path('core.php'),
        ]);
    }
}
