<?php


namespace LearningBundle\Service\Course;


use Doctrine\Common\Collections\ArrayCollection;
use LearningBundle\Entity\Course;
use LearningBundle\Entity\Lector;

interface CourseServiceInterface
{
    /**
     * @return ArrayCollection
     */
    public function getAll();
    public function create(Course $course, Lector $lector) : bool;
    public function edit(Course $course) : bool;
    public function delete(Course $course) : bool;
    public function getOne(int $id) : ?Course;

    /**
     * @return ArrayCollection
     */
    public function getAllCoursesByAuthor();
}