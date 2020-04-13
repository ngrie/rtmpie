<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\StreamEndedEvent;
use App\Event\StreamStartedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SetStreamLiveEventSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
        $event->getStream()->setLive(true);
        $this->entityManager->flush();
    }

    public function onStreamEnded(StreamEndedEvent $event)
    {
        $event->getStream()->setLive(false);
        $this->entityManager->flush();
    }
}
