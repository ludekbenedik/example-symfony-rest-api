<?php


namespace AppBundle\Security;


class ApiKeyVerifier implements ApiKeyVerifierInterface
{
    /** @var string */
    private $key;


    public function __construct(string $key)
    {
        $this->key = $key;
    }


    /**
     * {@inheritdoc}
     */
    public function verify(string $key): bool
    {
        return $key === $this->key;
    }
}
