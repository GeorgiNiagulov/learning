<?php


namespace LearningBundle\Service\Article;


use Doctrine\Common\Collections\ArrayCollection;
use LearningBundle\Entity\Article;

interface ArticleServiceInterface
{
    /**
     * @return ArrayCollection
     */
    public function getAll();
    public function create(Article $article) : bool;
    public function edit(Article $article) : bool;
    public function delete(Article $article) : bool;
    public function getOne(int $id) : ?Article;

    /**
     * @return ArrayCollection
     */
    public function getAllArticlesByAuthor();
}