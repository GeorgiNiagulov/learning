<?php

namespace LearningBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\ORMException;
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

    /**
     * @param Article $article
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert(Article $article)
    {
        try {
            $this->_em->persist($article);
            $this->_em->flush();
            return true;
        } catch (ORMException $e) {
            return false;
        }
    }

    /**
     * @param Article $article
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Article $article)
    {
        try {
            $this->_em->merge($article);
            $this->_em->flush();
            return true;
        } catch (ORMException $e) {
            return false;
        }
    }

    /**
     * @param Article $article
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Article $article)
    {
        try {
            $this->_em->remove($article);
            $this->_em->flush();
            return true;
        } catch (ORMException $e) {
            return false;
        }
    }
}
