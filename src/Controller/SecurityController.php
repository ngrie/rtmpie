<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     *
     * @throws ExceptionInterface
     */
    public function login(NormalizerInterface $normalizer): Response
    {
        $user = $this->getUser();

        return $this->json($normalizer->normalize($user, 'json', ['groups' => 'read']));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        // we should not get to this point
        throw new \RuntimeException();
    }
}
