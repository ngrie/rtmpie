<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\ChangePasswordRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class ChangePasswordRequestHandler implements MessageHandlerInterface
{
    public function __construct(
        private Security $security,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager
    )
    {}

    public function __invoke(ChangePasswordRequest $request)
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new \RuntimeException(sprintf('User must be an instance of %s', User::class));
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $request->password));
        $this->entityManager->flush();
    }
}
