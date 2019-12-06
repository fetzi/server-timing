<?php

namespace Fetzi\ServerTiming\Tests;

use Fetzi\ServerTiming\ServerTimings;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ServerTimingsTest extends TestCase
{
    public function testWithEmptyTimings()
    {
        $serverTimings = new ServerTimings;
        $response = $this->prophesize(ResponseInterface::class);

        $response->withAddedHeader()->shouldNotBeCalled();

        $serverTimings->addToResponse($response->reveal());
    }

    public function testWithAddedTimings()
    {
        $serverTimings = new ServerTimings;
        $serverTimings->create('foo');
        $serverTimings->create('bar');
        $response = $this->prophesize(ResponseInterface::class);

        $response
            ->withAddedHeader('Server-Timing', 'foo, bar')
            ->willReturn($response)
            ->shouldBeCalled();

        $serverTimings->addToResponse($response->reveal());
    }
}
