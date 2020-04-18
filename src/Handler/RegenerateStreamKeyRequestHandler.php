<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\RegenerateStreamKeyRequest;
use App\Entity\Stream;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegenerateStreamKeyRequestHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(RegenerateStreamKeyRequest $request)
    {
        $stream = $this->entityManager->getRepository(Stream::class)->findOneById($request->streamId);
        if (!$stream) {
            throw new NotFoundHttpException();
        }

        $stream->setKey(str_replace('-', '', uuid_create()));
        $this->entityManager->flush();
    }
}
