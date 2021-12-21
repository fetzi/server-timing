<?php

namespace Fetzi\ServerTiming;

class ServerTiming implements \Stringable
{
    private ?float $start = null;

    private ?float $end = null;

    public function __construct(private string $name, private ?string $description = null)
    {
    }

    /**
     * captures the starting microtime value for the server timing.
     *
     * @param float $fixedValue allows to set start to a predefined value
     */
    public function start(float $fixedValue = null): void
    {
        $this->start = $fixedValue ?? microtime(true);
    }

    /**
     * captures the end microtime value for the server timing.
     */
    public function stop(): void
    {
        $this->end = microtime(true);
    }

    public function __toString(): string
    {
        $timing = $this->name;

        if (!is_null($this->description)) {
            $timing .= sprintf(';desc="%s"', $this->description);
        }

        if (!is_null($this->start) && !is_null($this->end)) {
            $duration = round(($this->end - $this->start) * 1000, 1);
            $timing .= sprintf(';dur=%.1f', $duration);
        }

        return $timing;
    }
}
