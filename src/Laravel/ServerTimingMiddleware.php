<?php

namespace Fetzi\ServerTiming\Laravel;

use Closure;
use Fetzi\ServerTiming\ServerTimings;

class ServerTimingMiddleware
{
    private const REQUEST_TIME = 'REQUEST_TIME_FLOAT';

    /**
     * @var ServerTimings
     */
    private $serverTimings;

    public function __construct(ServerTimings $serverTimings)
    {
        $this->serverTimings = $serverTimings;
    }

    public function handle($request, Closure $next)
    {
        if (isset($_SERVER[static::REQUEST_TIME])) {
            $bootstrap = $this->serverTimings->create('Bootstrap');
            $bootstrap->start($_SERVER[static::REQUEST_TIME]);
            $bootstrap->stop();
        }

        $requestServerTiming = $this->serverTimings->create('Request');
        $requestServerTiming->start();

        $response = $next($request);

        $requestServerTiming->stop();

        return $response->header('Server-Timing', $this->serverTimings->getTimings());
    }
}
