<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Stream;
use Symfony\Contracts\EventDispatcher\Event;

abstract class StreamEvent extends Event
{
    private Stream $stream;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    public function getStream(): Stream
    {
        return $this->stream;
    }
}
