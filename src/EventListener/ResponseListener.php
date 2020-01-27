<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseListener implements EventSubscriberInterface
{
    private $resource;

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        $this->resource = str_replace('/', '', strrchr($event->getRequest()->getUri(), '/'));
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($this->resource) {
            $nbResults = count(json_decode($response->getContent()));
            $nbPAges = ceil($nbResults / 30);
            $header = $this->resource . ' 0-' . $nbPAges . '/' . $nbResults;
            $response->headers->set('Content-Range', $header);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
