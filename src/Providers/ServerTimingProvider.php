<?php

namespace Fetzi\ServerTiming\Providers;

use Fetzi\ServerTiming\ServerTimings;
use Illuminate\Support\ServiceProvider;

class ServerTimingProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ServerTimings::class, fn () => new ServerTimings);
    }
}
