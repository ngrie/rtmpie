<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Stream;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class StreamSlugAndKeyGenerator
{
    private EntityManagerInterface $entityManager;
    private SluggerInterface $slugger;

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
    }

    public function prePersist(Stream $stream, LifecycleEventArgs $event)
    {
        $stream->setKey($this->generateKey());

        // Generate a unique slug
        $slug = $this->slug($stream->getName());
        $slugSuffix = null;
        while (true) {
            if ($slugSuffix) {
                $stream->setSlug(sprintf('%s-%d', $slug, $slugSuffix));
            } else {
                $stream->setSlug($slug);
            }

            if ($this->isSlugAvailable($stream->getSlug())) {
                break;
            }

            $slugSuffix = !$slugSuffix ? 1 : $slugSuffix + 1;
        }
    }

    private function slug(string $input): string
    {
        return strtolower($this->slugger->slug($input)->toString());
    }

    private function generateKey(): string
    {
        return str_replace('-', '', uuid_create());
    }

    private function isSlugAvailable(string $slug): bool
    {
        try {
            $result = $this->entityManager->createQueryBuilder()
                ->select('s.slug')
                ->from(Stream::class, 's')
                ->where('s.slug = :slug')
                ->setParameter('slug', $slug)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return false;
        }

        if ($result) {
            return false;
        }

        foreach ($this->entityManager->getUnitOfWork()->getScheduledEntityInsertions() as $entity) {
            if (!$entity instanceof Stream) {
                continue;
            }

            if ($entity->getSlug() === $slug) {
                return false;
            }
        }

        return true;
    }
}
