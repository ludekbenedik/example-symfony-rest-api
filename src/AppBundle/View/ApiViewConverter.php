<?php

namespace AppBundle\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ApiViewConverter
{
    /** @var ApiSerializer */
    private $apiSerializer;


    public function __construct(ApiSerializer $apiSerializer)
    {
        $this->apiSerializer = $apiSerializer;
    }


    public function convert(ApiView $apiView, Request $request): Response
    {
        $format = $this->apiSerializer->guessFormat($request);
        $content = $this->apiSerializer->serialize($apiView->getObject(), $format);
        $contentType = $this->apiSerializer->getContentType($format);

        return new Response($content, $apiView->getHttpStatus(), [
            'Content-Type' => $contentType,
        ]);
    }
}
