<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Stream;
use App\Repository\StreamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/api/thumbnails")
 */
class ThumbnailController extends AbstractController
{
    private StreamRepository $streamRepository;
    private HttpClientInterface $httpClient;
    private string $rtmpThumbnailsBaseUrl;

    public function __construct(StreamRepository $streamRepository, HttpClientInterface $httpClient, string $rtmpThumbnailsBaseUrl)
    {
        $this->streamRepository = $streamRepository;
        $this->httpClient = $httpClient;
        $this->rtmpThumbnailsBaseUrl = $rtmpThumbnailsBaseUrl;
    }

    /**
     * @Route("/")
     */
    public function list()
    {
        $streams = $this->streamRepository->findBy(['live' => true]);
        $result = [];
        foreach($streams as $stream) {
            if ($this->getImage($stream)) {
                $result[$stream->getId()] = $this->generateUrl('stream_thumbnail', [
                    'streamId' => $stream->getId(),
                    't' => time(), // cache busting
                ]);
            }
        }

        return $this->json($result);
    }

    /**
     * @Route("/{streamId}", name="stream_thumbnail")
     */
    public function image($streamId)
    {
        $stream = $this->streamRepository->findOneById($streamId);
        if (!$stream) {
            throw new NotFoundHttpException();
        }

        return $this->getImage($stream);
    }

    private function getImage(Stream $stream)
    {
        $file = $this->httpClient->request('GET', $this->rtmpThumbnailsBaseUrl . $stream->getSlug() . '.png');
        if ($file->getStatusCode() !== 200) {
            return null;
        }

        $response = new Response();
        $response->setContent($file->getContent());
        $response->headers->replace($file->getHeaders());
        return $response;
    }
}
