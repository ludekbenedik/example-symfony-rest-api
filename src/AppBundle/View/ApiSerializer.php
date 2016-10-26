<?php

namespace AppBundle\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ApiSerializer
{
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';


    /** @var Serializer */
    private $serializer;


    public function guessFormat(Request $request)
    {
        $contentType = $request->getContentType();

        if ('xml' === $contentType) {
            return self::FORMAT_XML;
        }

        return self::FORMAT_JSON;
    }


    public function serialize($object, string $format): string
    {
        return $this->getSerializer()->serialize($object, $format);
    }


    /**
     * @return object
     */
    public function deserialize(string $data, string $class, string $format)
    {
        return $this->getSerializer()->deserialize($data, $class, $format);
    }


    private function getSerializer(): Serializer
    {
        if (null === $this->serializer) {
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
            $this->serializer = new Serializer($normalizers, $encoders);
        }

        return $this->serializer;
    }
}
