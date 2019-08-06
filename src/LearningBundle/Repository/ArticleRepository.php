<?php

namespace LearningBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use LearningBundle\Entity\Article;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $em, Mapping\ClassMetadata $metaData=null)
    {
        parent::__construct($em,
            $metaData == null ?
                new Mapping\ClassMetadata(Article::class):
                $metaData
        );
    }
}
