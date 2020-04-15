<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Stream;
use App\EntityPublisher;
use App\Event\StreamViewerEnteredEvent;
use App\Event\StreamViewerLeftEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateStreamViewerCountEventSubscriber implements EventSubscriberInterface
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
            StreamViewerEnteredEvent::NAME => ['incrementViewerCount'],
            StreamViewerLeftEvent::NAME => ['decrementViewerCount'],
        ];
    }

    public function incrementViewerCount(StreamViewerEnteredEvent $event)
    {
        $stream = $event->getStream();
        $this->entityManager->createQuery(
            'UPDATE ' . Stream::class . ' s
                SET s.viewerCount = s.viewerCount + 1
                WHERE s.id = :id'
        )
            ->setParameter('id', $stream->getId())
            ->execute();

        $this->entityManager->refresh($stream);
        $this->publisher->publish($stream);
    }

    public function decrementViewerCount(StreamViewerLeftEvent $event)
    {
        $stream = $event->getStream();
        $this->entityManager->createQuery(
            'UPDATE ' . Stream::class . ' s
                SET s.viewerCount = s.viewerCount - 1
                WHERE s.id = :id'
        )
            ->setParameter('id', $stream->getId())
            ->execute();

        $this->entityManager->createQueryBuilder()
            ->update(Stream::class, 's')
            ->set('s.viewerCount', 0)
            ->where('s.viewerCount < 0')
            ->getQuery()
            ->execute();

        $this->entityManager->refresh($stream);
        $this->publisher->publish($stream);
    }
}
