<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Stream;
use App\Event\StreamEndedEvent;
use App\Event\StreamStartedEvent;
use App\Event\StreamViewerEnteredEvent;
use App\Event\StreamViewerLeftEvent;
use App\Repository\StreamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Route('/rtmp-events')]
class RtmpEventsController
{
    private StreamRepository $streamRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(StreamRepository $streamRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->streamRepository = $streamRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    #[Route('/play', methods: ['POST'])]
    public function playEvent(Request $request): Response
    {
        $stream = $this->getStreamFromRequest($request);

        $this->eventDispatcher->dispatch(new StreamViewerEnteredEvent($stream), StreamViewerEnteredEvent::NAME);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/play-done', methods: ['POST'])]
    public function playDoneEvent(Request $request): Response
    {
        $stream = $this->getStreamFromRequest($request);

        $this->eventDispatcher->dispatch(new StreamViewerLeftEvent($stream), StreamViewerLeftEvent::NAME);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/publish', methods: ['POST'])]
    public function publishEvent(Request $request): Response
    {
        $key = $request->request->get('key');
        if (empty($key)) {
            throw new BadRequestHttpException();
        }

        $stream = $this->getStreamFromRequest($request);
        if ($stream->getKey() !== $key) {
            throw new AccessDeniedHttpException();
        }

        $this->eventDispatcher->dispatch(new StreamStartedEvent($stream), StreamStartedEvent::NAME);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/publish-done', methods: ['POST'])]
    public function publishDoneEvent(Request $request): Response
    {
        $stream = $this->getStreamFromRequest($request);

        $this->eventDispatcher->dispatch(new StreamEndedEvent($stream), StreamEndedEvent::NAME);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    private function getStreamFromRequest(Request $request): Stream
    {
        $app = $request->request->get('app');
        $slug = $request->request->get('name');
        if (empty($app) || empty($slug)) {
            throw new BadRequestHttpException();
        }

        $stream = $this->streamRepository->findOneBySlug($slug);
        if (!$stream) {
            throw new NotFoundHttpException();
        }

        return $stream;
    }
}
