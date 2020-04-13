<?php

declare(strict_types=1);

namespace App\Event;

class StreamViewerLeftEvent extends StreamEvent
{
    public const NAME = 'stream.viewer_left';
}
