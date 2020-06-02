<?php

declare(strict_types=1);

namespace App;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

class EntityPublisher
{
    private IriConverterInterface $iriConverter;
    private SerializerInterface $serializer;
    private PublisherInterface $publisher;

    public function __construct(
        IriConverterInterface $iriConverter,
        SerializerInterface $serializer,
        PublisherInterface $publisher
    )
    {
        $this->iriConverter = $iriConverter;
        $this->serializer = $serializer;
        $this->publisher = $publisher;
    }

    public function publish($entity)
    {
        $iri = $this->iriConverter->getIriFromItem($entity);
        $update = new Update(
            $iri,
            $this->serializer->serialize($entity, 'json', ['groups' => ['read']])
        );
        ($this->publisher)($update);
    }
}
