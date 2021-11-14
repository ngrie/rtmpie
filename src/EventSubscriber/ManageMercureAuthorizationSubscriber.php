<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use App\Mercure\TopicsHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mercure\Authorization;
use Symfony\Component\Security\Core\Security;

class ManageMercureAuthorizationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Authorization $authorization,
        private TopicsHelper $topicsHelper,
        private Security $security,
    )
    {}

    public function onResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (str_starts_with($request->getRequestUri(), '/rtmp-events/')) {
            return;
        }

        if ($this->security->getUser() !== null) {
            $this->authorization->setCookie($request, $this->topicsHelper->getMercureTopics());
        } else {
            $this->authorization->clearCookie($request);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => ['onResponse'],
        ];
    }
}
