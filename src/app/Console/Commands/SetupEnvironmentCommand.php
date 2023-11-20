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
    public function handle()
    {
        $this->call('migrate');
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }
        $this->seed('IBoot\\Core\\Database\\Seeders\\UserSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\PluginSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\MenuItemSeeder');
        $this->seed('IBoot\\Core\\Database\\Seeders\\SystemSettingSeeder');

        $this->info('Environment setup completed.');
    }

    protected function seed($class)
    {
        $this->call('db:seed', ['--class' => $class]);
        $this->info("Seeded: $class");
    }
}
