<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\ChangePasswordRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class ChangePasswordRequestHandler implements MessageHandlerInterface
{
    private Security $security;
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;

    public function __construct(
        Security $security,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    )
    {
        $this->security = $security;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function __invoke(ChangePasswordRequest $request)
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new \RuntimeException(sprintf('User must be an instance of %s', User::class));
        }

        $user->setPassword($this->passwordEncoder->encodePassword($user, $request->password));
        $this->entityManager->flush();
    }
}
