<?php

namespace AppBundle\EventListener;

use App\Api\Entity\Violation;
use App\Api\Response\UnprocessableEntityResponse;
use AppBundle\ApiRequestAttributes;
use AppBundle\Security\ApiKeyVerifierInterface;
use AppBundle\View\ApiView;
use AppBundle\View\ApiViewConverter;
use AppBundle\View\ApiSerializer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ApiRequestListener extends AbstractApiListener implements EventSubscriberInterface
{
    /** @var ApiSerializer */
    private $apiSerializer;

    /** @var ApiViewConverter */
    private $apiViewConverter;

    /** @var ApiKeyVerifierInterface */
    private $apiKeyVerifier;

    /** @var TranslatorInterface */
    private $translator;

    /** @var ValidatorInterface */
    private $validator;


    public function __construct(
        ApiSerializer $apiSerializer,
        ApiViewConverter $apiViewConverter,
        ApiKeyVerifierInterface $apiKeyVerifier,
        TranslatorInterface $translator,
        ValidatorInterface $validator
    ) {
        $this->apiSerializer = $apiSerializer;
        $this->apiViewConverter = $apiViewConverter;
        $this->apiKeyVerifier = $apiKeyVerifier;
        $this->translator = $translator;
        $this->validator = $validator;
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            // Run after routing_listener with priority 32 but before locale_listener with priority 16
            KernelEvents::REQUEST => ['onKernelRequest', 30],
        ];
    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$this->isApiRequest($event->getRequest())) {
            return;
        }

        $request = $event->getRequest();
        $request->attributes->add(ApiRequestAttributes::normalize($request->attributes->all()));

        if (!$this->authorize($request)) {
            $response = new Response('', Response::HTTP_UNAUTHORIZED);
            $event->setResponse($response);

            return;
        }

        $this->setLocale($request);
        $this->setApiRequest($event);
    }


    private function authorize(Request $request): bool
    {
        $authorize = $request->attributes->get(ApiRequestAttributes::AUTHORIZE);

        if (!$authorize) {
            return true;
        }

        $key = $request->headers->get('X-Api-Key', '');

        if ($this->apiKeyVerifier->verify($key)) {
            return true;
        }

        return false;
    }


    private function setLocale(Request $request)
    {
        $locale = $request->getPreferredLanguage();

        if (null !== $locale) {
            try {
                $this->translator->setLocale($locale);
                $request->attributes->set('_locale', $locale);
            } catch (\InvalidArgumentException $e) {
                $this->translator->setLocale($request->getDefaultLocale());
            }
        }
    }


    private function setApiRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $class = $request->attributes->get(ApiRequestAttributes::REQUEST_CLASS);

        if (null === $class) {
            return;
        }

        $format = $this->apiSerializer->guessFormat($request);
        $apiRequest = $this->apiSerializer->deserialize($request->getContent(), $class, $format);
        $violations = $this->validator->validate($apiRequest);

        if ($violations->count()) {
            $response = $this->createUnprocessableEntityResponse($violations, $request);
            $event->setResponse($response);
            return;
        }

        $request->attributes->set(ApiRequestAttributes::REQUEST, $apiRequest);
    }


    private function createUnprocessableEntityResponse(ConstraintViolationListInterface $violations, Request $request): Response
    {
        $apiViolations = [];

        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $apiViolations[] = new Violation($violation->getPropertyPath(), $violation->getMessage());
        }

        $apiResponse = new UnprocessableEntityResponse($apiViolations);
        $apiView = new ApiView($apiResponse, Response::HTTP_UNPROCESSABLE_ENTITY);

        return $this->apiViewConverter->convert($apiView, $request);
    }
}
