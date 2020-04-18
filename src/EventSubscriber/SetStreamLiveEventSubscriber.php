<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\EntityPublisher;
use App\Event\StreamEndedEvent;
use App\Event\StreamStartedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SetStreamLiveEventSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;
    private EntityPublisher $publisher;

    public function __construct(EntityManagerInterface $entityManager, EntityPublisher $publisher)
    {
        $this->entityManager = $entityManager;
        $this->publisher = $publisher;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            StreamStartedEvent::NAME => ['onStreamStarted'],
            StreamEndedEvent::NAME => ['onStreamEnded'],
        ];
    }

    public function onStreamStarted(StreamStartedEvent $event)
    {
        $stream = $event->getStream();
        $stream->setLive(true);
        $this->entityManager->flush();

        $this->publisher->publish($stream);
    }

    public function onStreamEnded(StreamEndedEvent $event)
    {
        $stream = $event->getStream();
        $stream->setLive(false);
        $stream->setViewerCount(0);
        $this->entityManager->flush();

        $this->publisher->publish($stream);
    }
}
