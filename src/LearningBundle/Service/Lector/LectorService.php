<?php


namespace LearningBundle\Service\Lector;


use LearningBundle\Entity\Lector;
use LearningBundle\Repository\LectorRepository;

class LectorService implements LectorServiceInterface
{

    private $lectorRepository;

    /**
     * LectorService constructor.
     * @param $lectorRepository
     */
    public function __construct(LectorRepository $lectorRepository)
    {
        $this->lectorRepository = $lectorRepository;
    }

    /**
     * @param string $name
     * @return Lector|null|object
     */
    public function findOneByName(string $name): ?Lector
    {
        return $this->lectorRepository->findOneBy(['name' => $name]);
    }

    public function save(Lector $lector): bool
    {
        return $this->lectorRepository->insert($lector);
    }

    public function update(Lector $lector): bool
    {
        return $this->lectorRepository->update($lector);
    }

    /**
     * @param int $id
     * @return Lector|null|object
     */
    public function findOneById(int $id): ?Lector
    {
        return $this->lectorRepository->find($id);
    }

    /**
     * @param Lector $lector
     * @return Lector|null|object
     */
    public function findOne(Lector $lector): ?Lector
    {
        return $this->lectorRepository->find($lector);
    }

}