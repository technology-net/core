<?php

namespace IBoot\Core\App\Providers;

use IBoot\Core\App\View\Components\Sidebar;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class CoreServiceProvider extends ServiceProvider
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
        $this->registerPolicies();
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Supper Admin') ? true : null;
        });

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return '\\IBoot\\Core\\App\\Policies\\' . class_basename($modelClass) . 'Policy';
        });
    }
}
