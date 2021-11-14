<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\CreateUserRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserRequestHandler implements MessageHandlerInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager
    )
    {}

    public function __invoke(CreateUserRequest $request)
    {
        if ($this->entityManager->getRepository(User::class)->findOneByUsername($request->username)) {
            throw new BadRequestHttpException('Username is already taken');
        }

        $user = new User();
        $user->setUsername($request->username);
        $user->setPassword($this->passwordHasher->hashPassword($user, $request->password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
