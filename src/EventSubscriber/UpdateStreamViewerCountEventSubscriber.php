<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\Stream;
use App\Event\StreamViewerEnteredEvent;
use App\Event\StreamViewerLeftEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateStreamViewerCountEventSubscriber implements EventSubscriberInterface
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
            StreamViewerEnteredEvent::NAME => ['incrementViewerCount'],
            StreamViewerLeftEvent::NAME => ['decrementViewerCount'],
        ];
    }

    public function incrementViewerCount(StreamViewerEnteredEvent $event)
    {
        $this->entityManager->createQuery(
            'UPDATE ' . Stream::class . ' s
                SET s.viewerCount = s.viewerCount + 1
                WHERE s.id = :id'
        )
            ->setParameter('id', $event->getStream()->getId())
            ->execute();
    }

    public function decrementViewerCount(StreamViewerLeftEvent $event)
    {
        $this->entityManager->createQuery(
            'UPDATE ' . Stream::class . ' s
                SET s.viewerCount = s.viewerCount - 1
                WHERE s.id = :id'
        )
            ->setParameter('id', $event->getStream()->getId())
            ->execute();

        $this->entityManager->createQueryBuilder()
            ->update(Stream::class, 's')
            ->set('s.viewerCount', 0)
            ->where('s.viewerCount < 0')
            ->getQuery()
            ->execute();
    }
}
