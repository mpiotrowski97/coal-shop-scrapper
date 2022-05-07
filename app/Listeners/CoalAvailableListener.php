<?php

namespace App\Listeners;

use App\Events\CoalAvailableEvent;
use App\Mail\NewCoalItem;
use Illuminate\Support\Facades\Mail;

class CoalAvailableListener
{
    public function handle(CoalAvailableEvent $event): void
    {
        Mail::to('97.piotrowski.michal@gmail.com')
            ->send(new NewCoalItem());
    }
}
