<?php

namespace IBoot\Core\App\Providers;

use IBoot\Core\App\Models\SystemSetting;
use IBoot\Core\App\View\Components\Sidebar;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNAdapter;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNClient;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;
use IBoot\Core\App\Console\Commands\SetupEnvironmentCommand;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
            SetupEnvironmentCommand::class
        ]);

        $this->publishes([
            __DIR__ . '/../../config' => config_path(),
        ]);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Supper Admin') ? true : null;
        });

        $this->setupDisk();
        $this->setupEmail();
        $this->initBunnyCDN();
    }

    private function setupDisk()
    {
        if (Schema::hasTable('system_settings')) {
            $disk = SystemSetting::query()
                ->where('key', 'filesystem_disk')
                ->first();
            if (!empty($disk)) {
                $setting = SystemSetting::query()
                    ->where('key', $disk->value)
                    ->first();

                config([
                    'filesystems.default' => $disk->value,
                ]);
                config([
                    'filesystems.disks.' . $setting->key  => json_decode($setting->value, true),
                ]);
            }
        }
        return config('filesystems.default');
    }

    private function setupEmail()
    {
        if (Schema::hasTable('system_settings')) {
            $transport = SystemSetting::query()
                ->where('key', 'transport')
                ->first();
            if (!empty($transport)) {
                $setting = SystemSetting::query()
                    ->where('key', $transport->value)
                    ->first();

                config([
                    'mail.default' => $transport->value,
                ]);

                config([
                    'mail.mailers.' . $setting->key  => json_decode($setting->value, true),
                ]);
            }
        }
        return config('mail.default');
    }

    private function initBunnyCDN()
    {
        Storage::extend('bunnycdn', function ($app, $config) {
            $adapter = new BunnyCDNAdapter(
                new BunnyCDNClient(
                    $config['storage_zone'],
                    $config['api_key'],
                    $config['region']
                )
            );

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}
