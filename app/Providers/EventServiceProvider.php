<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'App\Events\CoalAvailableEvent' => [
            'App\Listeners\CoalAvailableListener',
        ],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
