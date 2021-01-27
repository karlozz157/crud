<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Form;
use App\Manager\FileManager;

/**
 * @Route("/post")
 */
class PostController extends CrudController
{
    /**
     * @const string
     */
    const UPLOAD_DIRECTORY = 'uploads';

    /**
     * @param Form $form
     * @param $entity
     * 
     * @return void
     */
    protected function uploadFile(FileManager $fileManager, Form $form, $entity): void
    {
        $file = $form->get('photo')->getData();

        if ($file) {
            $fileManager->setTargetDirectory(static::UPLOAD_DIRECTORY);
            $filename = $fileManager->upload($file);
            $entity->setPhoto($filename);
        }
    }
}
