<?php


namespace LearningBundle\Service\Article;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use LearningBundle\Entity\Article;
use LearningBundle\Repository\ArticleRepository;
use LearningBundle\Service\Users\UserServiceInterface;

class ArticleService implements ArticleServiceInterface
{
    private $articleRepository;
    private $userService;
    public function __construct(ArticleRepository $articleRepository,
                                UserServiceInterface $userService)
    {
        $this->articleRepository = $articleRepository;
        $this->userService = $userService;
    }

    /**
     * @param Article $article
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Article $article): bool
    {
        $author = $this->userService->currentUser();
        $article->setAuthor($author);
        $article->setViewCount(0);
        return $this->articleRepository->insert($article);
    }

    /**
     * @param Article $article
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function edit(Article $article): bool
    {
        return $this->articleRepository->update($article);
    }

    /**
     * @param Article $article
     * @return bool
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Article $article): bool
    {
        return $this->articleRepository->remove($article);
    }

    public function getAll()
    {
        return $this->articleRepository->findAll();
    }

    /**
     * @param int $id
     * @return Article|null|object
     */
    public function getOne(int $id): ?Article
    {
        return $this->articleRepository->find($id);
    }

    /**
     * @return ArrayCollection|Article[]
     */
    public function getAllArticlesByAuthor()
    {
        return $this->articleRepository
            ->findBy(
                [],
                [
                    'dateAdded'=> 'DESC'
                ]
            );
    }
}