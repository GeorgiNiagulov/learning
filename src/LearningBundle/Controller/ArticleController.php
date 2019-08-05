<?php

namespace LearningBundle\Controller;

use LearningBundle\Entity\Article;
use LearningBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/create", name="article_create", methods={"GET"})
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

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/edit/{id}", name="article_edit")
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
     * @Route("/delete/{id}", name="article_delete")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, Article $article)
    {

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
     * @Route("/article/{id}", name="article_view")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view(Article $article)
    {
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        return $this->render("articles/view.html.twig",
            ['article' => $article]);

    }


}
