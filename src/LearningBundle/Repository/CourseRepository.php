<?php

namespace LearningBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use LearningBundle\Entity\Course;

/**
 * CourseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CourseRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $metaData=null)
    {
        parent::__construct($em,
            $metaData == null ?
                new Mapping\ClassMetadata(Course::class):
                $metaData
        );
    }

    /**
     * @param Course $course
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function insert(Course $course)
    {
        try {
            $this->_em->persist($course);
            $this->_em->flush();
            return true;
        } catch (ORMException $e) {
            return false;
        }
    }

    /**
     * @param Course $course
     * @return bool
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Course $course)
    {
        try {
            $this->_em->merge($course);
            $this->_em->flush();
            return true;
        } catch (ORMException $e) {
            return false;
        }
    }

    /**
     * @param Course $course
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Course $course)
    {
        try {
            $this->_em->remove($course);
            $this->_em->flush();
            return true;
        } catch (ORMException $e) {
            return false;
        }
    }
}
