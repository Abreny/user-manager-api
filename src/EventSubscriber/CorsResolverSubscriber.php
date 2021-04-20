<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CorsResolverSubscriber implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'PUT, GET, POST, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
        if ($event->getRequest()->isMethod('OPTIONS')) {
            $response->setContent(json_encode("OK"));
            $response->setStatusCode(200);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
