<?php


namespace LearningBundle\Service\Course;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use LearningBundle\Entity\Course;
use LearningBundle\Entity\Lector;
use LearningBundle\Repository\CourseRepository;
use LearningBundle\Service\Lector\LectorServiceInterface;

class CourseService implements CourseServiceInterface
{
    private $courseRepository;
    private $lectorService;

    /**
     * CourseService constructor.
     * @param $courseRepository
     * @param $lectorService
     */
    public function __construct(CourseRepository $courseRepository,
                                LectorServiceInterface $lectorService)
    {
        $this->courseRepository = $courseRepository;
        $this->lectorService = $lectorService;
    }


    public function getAll()
    {
        return $this->courseRepository->findAll();
    }

    public function create(Course $course, Lector $lector): bool
    {
        $lector = $this->lectorService->findOne($lector);
        $course->setName($lector);
        return $this->courseRepository->insert($course);
    }

    /**
     * @param Course $course
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function edit(Course $course): bool
    {
        return $this->courseRepository->update($course);
    }

    /**
     * @param Course $course
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Course $course): bool
    {
        return $this->courseRepository->remove($course);
    }

    /**
     * @param int $id
     * @return Course|null|object
     */
    public function getOne(int $id): ?Course
    {
        return $this->courseRepository->find($id);
    }

    /**
     * @return ArrayCollection|Course[]
     */
    public function getAllCoursesByAuthor()
    {
        return $this
            ->courseRepository
            ->findBy(
                [
                    'datetime' => 'DESC'
                ]
            );
    }
}