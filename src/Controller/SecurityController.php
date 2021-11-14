<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SecurityController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/login', name: 'login', methods: ['POST'])]
    #[Route('/me')]
    public function login(NormalizerInterface $normalizer): Response
    {
        $user = $this->getUser();

        if ($user instanceof User) {
            return $this->json($normalizer->normalize($user, 'json', ['groups' => 'read']));
        } else {
            return new Response(null, Response::HTTP_UNAUTHORIZED);
        }
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): Response
    {
        // we should not get to this point
        throw new \RuntimeException();
    }
}
