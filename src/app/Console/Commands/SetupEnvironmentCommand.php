<?php

namespace IBoot\Core\App\Console\Commands;

use Illuminate\Console\Command;

class SetupEnvironmentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:environment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup environment by running migrate, storage:link, and various seed commands';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->publishVendor('Spatie\Permission\PermissionServiceProvider');
        $this->call('migrate');
        $this->seed('IBoot\\Core\\Database\\Seeders\\UserSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\PluginSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\MenuItemSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\SystemSettingSeeder');

        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }

        $this->info('Environment setup completed.');
    }

    /**
     * @param $class
     * @return void
     */
    protected function seed($class): void
    {
        $this->call('db:seed', [
            '--class' => $class,
        ]);

        $this->info("Seeded: $class");
    }

    /**
     * @param $provider
     * @return void
     */
    protected function publishVendor($provider): void
    {
        $this->call('vendor:publish', [
            '--provider' => $provider,
        ]);

        $this->info("$provider setup completed.");
    }
}
