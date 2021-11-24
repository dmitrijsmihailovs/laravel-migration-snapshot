<?php


namespace AlwaysOpen\MigrationSnapshot;

final class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        // CONSIDER: Only registering these when Laravel version doesn't have
        // more specific hooks.
        'Illuminate\Console\Events\CommandFinished' => ['AlwaysOpen\MigrationSnapshot\Handlers\MigrateFinishedHandler'],
        'Illuminate\Console\Events\CommandStarting' => ['AlwaysOpen\MigrationSnapshot\Handlers\MigrateStartingHandler'],
    ];
}