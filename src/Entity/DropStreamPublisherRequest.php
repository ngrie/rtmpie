<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     messenger=true,
 *     collectionOperations={
 *         "post"={"status"=204},
 *     },
 *     itemOperations={},
 *     output=false,
 * )
 */
class DropStreamPublisherRequest
{
    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Type(type="integer")
     */
    public $streamId;

    /**
     * @var bool
     * @Assert\Type(type="bool")
     */
    public $regenerateStreamKey;
}
