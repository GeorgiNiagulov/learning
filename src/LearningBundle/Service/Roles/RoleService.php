<?php


namespace LearningBundle\Service\Roles;


use LearningBundle\Repository\RoleRepository;

class RoleService implements RoleServiceInterface
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function findOneBy(string $criteria)
    {
        return $this->roleRepository->findOneBy(
            ['name' => $criteria]
        );
    }
}