<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener(event: 'kernel.request', priority: 20)]
class LocaleListener
{
    public function __invoke(RequestEvent $event): void
    {
        $file = __DIR__ . '/../../var/site_language.txt';

        $locale = file_exists($file)
            ? trim(file_get_contents($file))
            : 'ru';

        $event->getRequest()->setLocale($locale);
    }
}