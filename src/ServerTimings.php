<?php

namespace Fetzi\ServerTiming;

use Psr\Http\Message\ResponseInterface;

class ServerTimings
{
    /**
     * @var array
     */
    private $timings = [];

    /**
     * creates a new ServerTiming instance and registers it
     *
     * @param string $name          the name of the server timing
     * @param string $description   the description for the server timing
     *
     * @return ServerTiming
     */
    public function create(string $name, ?string $description = null)
    {
        $serverTiming = new ServerTiming($name, $description);
        $this->timings[] = $serverTiming;

        return $serverTiming;
    }

    /**
     * returns the formatted Server-Timing header value
     *
     * @return string
     */
    public function getTimings(): ?string
    {
        if (empty($this->timings)) {
            return null;
        }

        return implode(', ', $this->timings);
    }

    /**
     * adds the stored server timings to the given response instance
     *
     * @param ResponseInterface $response the response to add to
     *
     * @return ResponseInterface
     */
    public function addToResponse(ResponseInterface $response): ResponseInterface
    {
        if (!empty($this->timings)) {
            $response = $response->withAddedHeader('Server-Timing', $this->getTimings());
        }

        return $response;
    }
}
