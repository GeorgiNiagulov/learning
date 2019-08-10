<?php

namespace LearningBundle\Controller;

use LearningBundle\Entity\Role;
use LearningBundle\Entity\User;
use LearningBundle\Form\UserType;
use LearningBundle\Service\Users\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("register", name="user_register", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        return $this->render('users/register.html.twig', [
            'form' => $this->createForm(UserType::class)->createView()
        ]);
    }

    /**
     * @Route("register", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function registerProcess(Request $request)
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if (null !== $this
                ->userService->findOneByEmail($form['email']->getData())) {
            $email =
                $this
                    ->userService->findOneByEmail($form['email']->getData())
                    ->getEmail();
            $this->addFlash("errors", "Имейл $email вече съществува!");
            return $this->render('users/register.html.twig',
                [
                    'user' => $user,
                    'form' => $this->createForm(UserType::class)
                    ->createView()
                ]);
        }

        if ($form['password']['first']->getData() !== $form['password']['second']->getData()){
            $this->addFlash("errors", "Паролата не съвпада!");
            return $this->render('users/register.html.twig',
                [
                    'user' => $user,
                    'form' => $this->createForm(UserType::class)
                        ->createView()
                ]);
        }
        $this->userService->save($user);

        return $this->redirectToRoute('security_login');
    }

    /**
     * @Route("/profile", name="user_profile")
     */
    public function profile()
    {
        return $this->render("users/profile.html.twig",
            ['user' => $this->userService->currentUser()]);
    }

    /**
     * @Route("/logout", name="security_logout")
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception("Logout failed!");
    }

    /**
     * @Route("/profile/edit", name="user_edit_profile",methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function edit()
    {
        $currentUser = $this->userService->currentUser();
        return $this->render('users/edit.html.twig',
            [
                'user' => $currentUser,
                'form' => $this
                    ->createForm(UserType::class)
                    ->createView()
            ]
            );
    }

    /**
     * @Route("/profile/edit", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return Response
     */
    public function editProcess(Request $request)
    {
        $currentUser = $this->userService->currentUser();
        $form = $this->createForm(UserType::class, $currentUser);

        if ($currentUser->getPassword() === $request->request->get('email')){
            $form->remove('email');
        }
        $form->remove('password');
        $form->handleRequest($request);
        $this->userService->update($currentUser);
        return $this->redirectToRoute("user_profile");
    }
}
