<?php

namespace IBoot\Core\App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

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
        $this->call('migrate');
        $this->seed('IBoot\\Core\\Database\\Seeders\\UserSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\PluginSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\MenuItemSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\SystemSettingSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\PermissionSeeder');
        $this->publishVendor('IBoot\Core\App\Providers\CoreServiceProvider', 'config');

        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }

        $this->call('optimize');
        $process = new Process(['composer', 'dump-autoload']);
        $process->run();

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
    protected function publishVendor($provider, $tag): void
    {
        $this->call('vendor:publish', [
            '--provider' => $provider,
            '--tag' => $tag,
        ]);

        $this->info("$provider setup completed.");
    }
}
