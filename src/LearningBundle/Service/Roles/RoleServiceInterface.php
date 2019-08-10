<?php


namespace LearningBundle\Service\Roles;


interface RoleServiceInterface
{
    public function findOneBy(string $criteria);
}