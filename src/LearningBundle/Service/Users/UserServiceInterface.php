<?php


namespace LearningBundle\Service\Users;


use LearningBundle\Entity\User;

interface UserServiceInterface
{
    public function findOneByEmail(string $email) : ?User;
    public function save(User $user) :bool;
    public function update(User $user) :bool;
    public function findOneById(int $id) : ?User;
    public function findOne(User $user) : ?User;
    public function currentUser() : ?User;
}