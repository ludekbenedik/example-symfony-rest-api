<?php


namespace AppBundle\Security;


interface ApiKeyVerifierInterface
{
    public function verify(string $key): bool;
}
