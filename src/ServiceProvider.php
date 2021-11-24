<?php

namespace AlwaysOpen\MigrationSnapshot;

use AlwaysOpen\MigrationSnapshot\Commands\MigrateDumpCommand;
use AlwaysOpen\MigrationSnapshot\Commands\MigrateLoadCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/migration-snapshot.php' => config_path('migration-snapshot.php'),
            ], 'config');

            $this->commands([
                MigrateDumpCommand::class,
                MigrateLoadCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/migration-snapshot.php', 'migration-snapshot');

        $this->app->register(EventServiceProvider::class);
    }
}
