<?php

namespace Fetzi\ServerTiming;

use Fetzi\ServerTiming\ServerTimings;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ServerTimingMiddleware implements MiddlewareInterface
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

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $serverParams = $request->getServerParams();
        if (isset($serverParams[static::REQUEST_TIME])) {
            $bootstrap = $this->serverTimings->create('Bootstrap');
            $bootstrap->start($serverParams[static::REQUEST_TIME]);
            $bootstrap->stop();
        }

        $requestServerTiming = $this->serverTimings->create('Request');
        $requestServerTiming->start();

        $response = $handler->handle($request);

        $requestServerTiming->stop();

        return $this->serverTimings->addToResponse($response);
    }
}
