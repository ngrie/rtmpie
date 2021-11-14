<?php

declare(strict_types=1);

namespace App;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

class EntityPublisher
{
    public function __construct(
        private IriConverterInterface $iriConverter,
        private SerializerInterface $serializer,
        private HubInterface $hub
    )
    {}

    public function publish($entity)
    {
        $iri = $this->iriConverter->getIriFromItem($entity);
        $update = new Update(
            $iri,
            $this->serializer->serialize($entity, 'json', ['groups' => ['read']]),
            true
        );

        $this->hub->publish($update);
    }
}
