<?php


namespace LearningBundle\Service\Lector;


use LearningBundle\Entity\Lector;

interface LectorServiceInterface
{
    public function findOneByName(string $name) : ?Lector;
    public function save(Lector $lector) :bool;
    public function update(Lector $lector) :bool;
    public function findOneById(int $id) : ?Lector;
    public function findOne(Lector $lector) : ?Lector;
}