<?php

namespace LearningBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lector
 *
 * @ORM\Table(name="lectors")
 * @ORM\Entity(repositoryClass="LearningBundle\Repository\LectorRepository")
 */
class Lector
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="LearningBundle\Entity\Course")
     * @ORM\JoinTable(name="courses_lectors",
     *        joinColumns={@ORM\JoinColumn(name="lector_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")}
     *     )
     */
    private $courses;
    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Lector
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Lector
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return ArrayCollection
     */
    public function getCourses(): ArrayCollection
    {
        return $this->courses;
    }

    /**
     * @param ArrayCollection $courses
     * @return Lector
     */
    public function setCourses(ArrayCollection $courses)
    {
        $this->courses = $courses;
        return $this;
    }
}

