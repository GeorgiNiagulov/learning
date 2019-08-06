<?php

namespace LearningBundle\Controller;

use LearningBundle\Entity\Article;
use LearningBundle\Entity\User;
use LearningBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/create", name="post_create", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {

        return $this->render('articles/create.html.twig',
            ['form' =>
                $this->createForm(ArticleType::class)
                    ->createView()]);
    }

    /**
     * @Route("/create", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createProcess(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $article->setAuthor($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $this->addFlash("create", "Успешно създадено!");

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/edit/{id}", name="post_edit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, $id)
    {
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        if (!$this->isAuthorOrAdmin($article)) {
            return $this->redirectToRoute('blog_index');
        }

        if (null === $article) {
            return $this->redirectToRoute('blog_index');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($article);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('articles/edit.html.twig',
            [
                'form' => $form->createView(),
                'article' => $article
            ]);
    }

    /**
     * @Route("/delete/{id}", name="post_delete")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, int $id)
    {
        $article =
            $this
                ->getDoctrine()
                ->getRepository(Article::class)
                ->find($id);

        if (null === $article) {
            return $this->redirectToRoute('blog_index');
        }

        if (!$this->isAuthorOrAdmin($article)) {
            return $this->redirectToRoute('blog_index');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('articles/delete.html.twig',
            [
                'form' => $form->createView(),
                'article' => $article
            ]);
    }

    /**
     * @Route("/post/{id}", name="post_view")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view(int $id)
    {
        $article =
            $this
                ->getDoctrine()
                ->getRepository(Article::class)
                ->find($id);

        if (null === $article) {
            return $this->redirectToRoute('blog_index');
        }

        $article->setViewCount($article->getViewCount()+1);
        $em= $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return $this->render("articles/view.html.twig",
            ['article' => $article]);

    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isAuthorOrAdmin(Article $article)
    {
        /**@var User $currentUser */
        $currentUser = $this->getUser();
        if (!$currentUser->isAuthor($article) && !$currentUser->isAdmin()) {
            return false;
        }
        return true;
    }

    /**
     * @Route("/posts/my_posts", name="my_posts")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllPostsByUser()
    {
        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['dateAdded'=> 'DESC']);

        return $this->render(
            "articles/myPosts.html.twig",
            [
                'articles' => $articles
            ]
        );
    }
}
