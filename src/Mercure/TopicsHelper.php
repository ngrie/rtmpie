<?php
declare(strict_types=1);

namespace App\Mercure;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TopicsHelper
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private array $mercureTopics,
    )
    {}

    public function getMercureTopics(): array
    {
        $baseUrl = $this->urlGenerator->generate('home', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $topics = [];
        foreach ($this->mercureTopics as $topic) {
            $topics[] = '/' . $topic;
            // this is necessary to catch updates triggered by API Platform
            $topics[] = $baseUrl . $topic;
        }

        return $topics;
    }
}
