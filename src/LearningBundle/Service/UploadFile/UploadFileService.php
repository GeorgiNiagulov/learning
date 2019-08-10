<?php


namespace LearningBundle\Service\UploadFile;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileService implements UploadFileServiceInterface
{
    /**
     * @var UploadedFile $file
     */
    private $file;
public function __construct(UploadedFile $file)
{
    $this->file = $file;
}

    public function upload()
    {
        /**@var UploadedFile $file */
        $file = $form['image']->getData();
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        if ($file){
            $file->move(
                $this->getParameter('posts_directory'),
                $filename
            );
            $article->setImage($filename);
        }
    }
}