<?php

namespace AppBundle\EventListener;

use AppBundle\View\ApiView;
use AppBundle\View\ApiViewConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class ApiViewListener implements EventSubscriberInterface
{
    /** @var ApiViewConverter */
    private $apiViewConverter;


    public function __construct(ApiViewConverter $apiViewConverter)
    {
        $this->apiViewConverter = $apiViewConverter;
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW=> ['onKernelView', 0],
        ];
    }


    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();

        if ($result instanceof ApiView) {
            $response = $this->apiViewConverter->convert($result, $event->getRequest());
            $event->setResponse($response);
        }
    }
}
