<?php

declare(strict_types=1);

namespace App\Event;

class StreamEndedEvent extends StreamEvent
{
    public const NAME = 'stream.ended';
}
