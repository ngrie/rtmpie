<?php

declare(strict_types=1);

namespace App\Event;

class StreamStartedEvent extends StreamEvent
{
    public const NAME = 'stream.started';
}
