<?php

namespace AppBundle\EventListener;

use App\Api\Exception\NotFoundException;
use App\Api\Response\MessageResponse;
use AppBundle\View\ApiView;
use AppBundle\View\ApiViewConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;


class ApiExceptionListener extends AbstractApiListener implements EventSubscriberInterface
{
    /** @var bool */
    private $debug;

    /** @var ApiViewConverter */
    private $apiViewConverter;


    public function __construct(bool $debug, ApiViewConverter $apiViewConverter)
    {
        $this->debug = $debug;
        $this->apiViewConverter = $apiViewConverter;
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            // Be careful about other exception listeners.
            // This listener should by first
            // or earlier listener have to set response only if they are responsible for concrete request
            KernelEvents::EXCEPTION => ['onKernelException', 200],
        ];
    }


    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$this->isApiRequest($event->getRequest())) {
            return;
        }

        $exception = $event->getException();

        if ($exception instanceof NotFoundHttpException) {
            $response = $this->createResponse($exception->getMessage(), Response::HTTP_NOT_FOUND, $event->getRequest());
            $event->setResponse($response);
            return;
        }

        if ($exception instanceof NotFoundException) {
            $response = $this->createResponse($exception->getMessage(), Response::HTTP_NOT_FOUND, $event->getRequest());
            $event->setResponse($response);
            return;
        }

        $message = $this->debug ? $exception->getMessage() : 'Internal server error.';
        $response = $this->createResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR, $event->getRequest());
        $event->setResponse($response);
    }


    private function createResponse(string $message, int $httpStatus, Request $request): Response
    {
        $apiResponse = new MessageResponse($message);
        $apiView = new ApiView($apiResponse, $httpStatus);

        return $this->apiViewConverter->convert($apiView, $request);
    }
}
