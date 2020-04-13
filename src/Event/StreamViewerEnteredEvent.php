<?php

declare(strict_types=1);

namespace App\Event;

class StreamViewerEnteredEvent extends StreamEvent
{
    public const NAME = 'stream.viewer_entered';
}
