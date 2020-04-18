<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\CreateUserRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserRequestHandler implements MessageHandlerInterface
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateUserRequest $request)
    {
        if ($this->entityManager->getRepository(User::class)->findOneByUsername($request->username)) {
            throw new BadRequestHttpException('Username is already taken');
        }

        $user = new User();
        $user->setUsername($request->username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $request->password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
