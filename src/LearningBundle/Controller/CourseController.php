<?php

namespace LearningBundle\Controller;

use LearningBundle\Entity\Course;
use LearningBundle\Form\CourseType;
use LearningBundle\Service\Course\CourseServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends Controller
{
    /**
     * @var CourseServiceInterface $courceService
     */
    private $courseService;

    /**
     * CourseController constructor.
     * @param CourseServiceInterface $courceService
     */
    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * @Route("/course/create", name="course_create", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function create()
    {

        return $this->render('courses/create.html.twig',
            ['form' =>
                $this->createForm(CourseType::class)
                    ->createView()]);
    }

    /**
     * @Route("/course/create", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return Response
     */
    public function createProcess(Request $request)
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        $this->uploadFile($form, $course);

        $this->courseService->create($course);

        $this->addFlash("create", "Успешно създадено!");

        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/course/edit/{id}", name="cource_edit", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $course = $this->courseService->getOne($id);

        if (!$this->isAuthorOrAdmin($course)) {
            return $this->redirectToRoute('blog_index');
        }

        if (null === $course) {
            return $this->redirectToRoute('blog_index');
        }

        return $this->render('courses/edit.html.twig',
            [
                'form' => $this->createForm(CourseType::class)
                    ->createView(),
                'course' => $course
            ]);
    }

    /**
     * @Route("/course/edit/{id}", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editProcess(Request $request, $id)
    {
        $course = $this->courseService->getOne($id);
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        $this->uploadFile($form, $course);
        $this->courseService->edit($course);
        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/course/delete/{id}", name="course_delete", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param int $id
     * @return Response
     */
    public function delete(int $id)
    {
        $course = $this->courseService->getOne($id);

        if (null === $course) {
            return $this->redirectToRoute('blog_index');
        }

        return $this->render('courses/delete.html.twig',
            [
                'form' => $this->createForm(CourseType::class)
                    ->createView(),
                'course' => $course
            ]);
    }

    /**
     * @Route("/course/delete/{id}", methods={"POST"})
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function deleteProcess(Request $request, int $id)
    {
        $course = $this->courseService->getOne($id);

        $form = $this->createForm(CourseType::class, $course);
        $form->remove('image');
        $form->handleRequest($request);
        $this->courseService->delete($course);
        return $this->redirectToRoute('blog_index');
    }

    /**
     * @Route("/course/{id}", name="course_view")
     * @param int $id
     * @return Response
     */
    public function view(int $id)
    {
        $course = $this->courseService->getOne($id);

        if (null === $course) {
            return $this->redirectToRoute('blog_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($course);
        $em->flush();

        return $this->render("courses/view.html.twig",
            [
                'course' => $course
            ]);

    }

    /**
     * @param FormInterface $form
     * @param Course $course
     */
    private function uploadFile(FormInterface $form, Course $course): void
    {
        /**@var UploadedFile $file */
        $file = $form['image']->getData();
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        if ($file) {
            $file->move(
                $this->getParameter('courses_directory'),
                $filename
            );
            $course->setImage($filename);
        }
    }
}
