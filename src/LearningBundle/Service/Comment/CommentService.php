<?php


namespace LearningBundle\Service\Comment;


use LearningBundle\Entity\Comment;
use LearningBundle\Repository\CommentRepository;
use LearningBundle\Service\Article\ArticleServiceInterface;
use LearningBundle\Service\Users\UserServiceInterface;

class CommentService implements CommentServiceInterface
{
    /**
     * @var UserServiceInterface
     */
    private $userService;
    private $commentRepository;
    private $articleService;

    public function __construct(CommentRepository $commentRepository,
                                UserServiceInterface $userService,
                                ArticleServiceInterface $articleService)
    {
        $this->commentRepository = $commentRepository;
        $this->userService = $userService;
        $this->articleService = $articleService;
    }


    /**
     * @return Comment[]
     */
    public function getAllByArticleId($articleId)
    {
        $article = $this->articleService->getOne($articleId);
        return $this
            ->commentRepository
            ->findBy(['article' => $article], ['dateAdded' => 'DESC']);
    }

    public function getOne(): ?Comment
    {
        // TODO: Implement getOne() method.
    }

    public function create(Comment $comment, $articleId): bool
    {
        $comment
            ->setAuthor($this->userService->currentUser())
            ->setArticle($this->articleService->getOne($articleId));
        return $this->commentRepository->insert($comment);
    }
}