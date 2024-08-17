<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\StreamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PublicPlayerController extends AbstractController
{
    #[Route('/play/{streamSlug}', name: 'public_player')]
    public function index(string $streamSlug, StreamRepository $streamRepository, string $rtmpHttpFlvBaseUrl): Response
    {
        $stream = $streamRepository->findOneBySlug($streamSlug);
        if (!$stream) {
            throw new NotFoundHttpException();
        }

        $url = "{$rtmpHttpFlvBaseUrl}/{$stream->getSlug()}/index.m3u8";

        return $this->render('public_player.html.twig', [
            'url' => $url,
        ]);
    }
}
