<?php


namespace LearningBundle\Service\Comment;


use LearningBundle\Entity\Comment;

interface CommentServiceInterface
{
    public function create(Comment $comment, int $articleId): bool;

    /**
     * @param int $articleId
     * @return Comment[]
     */
    public function getAllByArticleId(int $articleId);
    public function getOne(): ?Comment;
}