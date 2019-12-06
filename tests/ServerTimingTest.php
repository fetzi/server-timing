<?php

namespace Fetzi\ServerTiming\Tests;

use Fetzi\ServerTiming\ServerTiming;
use PHPUnit\Framework\TestCase;

class ServerTimingTest extends TestCase
{
    public function testOnlyWithName()
    {
        $st = new ServerTiming('foo');

        $this->assertEquals('foo', $st->__toString());
    }

    public function testWithNameAndDescription()
    {
        $st = new ServerTiming('foo', 'bar');

        $this->assertEquals('foo;desc="bar"', $st->__toString());
    }

    public function testWithNameAndOnlyStart()
    {
        $st = new ServerTiming('foo');
        $st->start();

        $this->assertEquals('foo', $st->__toString());
    }

    public function testWithNameStartAndEnd()
    {
        $st = new ServerTiming('foo');
        $st->start();
        $st->stop();

        $parts = explode('=', $st->__toString());
        $this->assertEquals('foo;dur', $parts[0]);
        $this->assertEqualsWithDelta(0.0, floatval($parts[1]), 0.2);
    }

    public function testWithFixedStart()
    {
        $st = new ServerTiming('request');
        $st->start(1575624547.2775);
        $st->stop();

        $parts = explode('=', $st->__toString());
        $this->assertGreaterThan(100, floatval($parts[1]));
    }
}
