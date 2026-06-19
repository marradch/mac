<?php

namespace App\EventSubscriber;

use App\Enum\Locale;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $locale = $event->getRequest()->attributes->get('locale');

        if (!$locale) {
            return;
        }

        if (!Locale::tryFrom($locale)) {
            throw new BadRequestHttpException("Unsupported locale '$locale'");
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 0],
        ];
    }
}
