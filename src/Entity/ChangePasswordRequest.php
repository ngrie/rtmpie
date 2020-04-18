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
class ChangePasswordRequest
{
    /**
     * @var string
     * @Assert\NotBlank
     */
    public $password;
}
