<?php


namespace LearningBundle\Service\Encryption;


interface EncryptionServiceInterface
{
    public function hash(string $password);
    public function verify(string $password, string $hash);
}