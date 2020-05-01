<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\DropStreamPublisherRequest;
use App\Entity\RegenerateStreamKeyRequest;
use App\Repository\StreamRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DropStreamPublisherRequestHandler implements MessageHandlerInterface
{
    private StreamRepository $streamRepository;
    private MessageBusInterface $bus;
    private HttpClientInterface $httpClient;
    private string $rtmpControlModuleBaseUrl;

    public function __construct(
        StreamRepository $streamRepository,
        MessageBusInterface $bus,
        HttpClientInterface $httpClient,
        string $rtmpControlModuleBaseUrl
    )
    {
        $this->streamRepository = $streamRepository;
        $this->bus = $bus;
        $this->httpClient = $httpClient;
        $this->rtmpControlModuleBaseUrl = $rtmpControlModuleBaseUrl;
    }

    public function __invoke(DropStreamPublisherRequest $request)
    {
        $stream = $this->streamRepository->findOneById($request->streamId);
        if (!$stream) {
            throw new NotFoundHttpException();
        }
        if (!$stream->isLive()) {
            throw new BadRequestHttpException('The given stream is not live at the moment');
        }

        $response = $this->httpClient->request(
            'GET',
            $this->rtmpControlModuleBaseUrl . 'drop/publisher',
            [
                'query' => [
                    'app' => 'live',
                    'name' => $stream->getSlug(),
                ],
            ]
        );
        if (intval($response->getContent()) <= 0) {
            throw new \RuntimeException('No connection has been dropped');
        }

        if ($request->regenerateStreamKey) {
            $regenerateStreamKeyRequest = new RegenerateStreamKeyRequest();
            $regenerateStreamKeyRequest->streamId = $stream->getId();
            $this->bus->dispatch($regenerateStreamKeyRequest);
        }
    }
}
