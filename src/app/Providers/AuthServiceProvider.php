<?php

namespace IBoot\Core\App\Providers;

use IBoot\Core\App\View\Components\Sidebar;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/core.php', 'core'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Blade::component('sidebar', Sidebar::class);

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'packages/core');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'packages/core');
        $this->commands([
            \IBoot\Core\App\Console\Commands\SetupEnvironmentCommand::class
        ]);

//        $this->publishes([
//            __DIR__ . '/../../database/migrations' => database_path('migrations'),
//            __DIR__ . '/../../database/seeders' => database_path('seeders'),
//            __DIR__ . '/../../config' => config_path(),
//            __DIR__ . '/../../lang' => lang_path(),
//            __DIR__ . '/../../resources/views' => resource_path('packages/core'),
//        ]);
    }
}