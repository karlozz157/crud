<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Form;
use App\Manager\Manager;
use App\Manager\FileManager;

abstract class CrudController extends AbstractController
{
    /**
     * @var string $className
     */
    protected $className;

    /**
     * @var string $entityName
     */
    protected $entityName;

    /**
     * @var string $formName
     */
    protected $formName;

    public function __construct() {
        $class = explode('\\', get_class($this));
        $class = str_replace('Controller', '', end($class));
        $this->className = strtolower($class);
        $this->entityName = "App\\Entity\\{$class}";
        $this->formName = "App\\Form\\{$class}Type";
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function index(Manager $manager): Response
    {
        $repository = $manager->getRepository($this->entityName);

        return $this->render("{$this->className}/index.html.twig", [
            'entities' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new", methods={"GET","POST"})
     */
    public function new(Request $request, Manager $manager, FileManager $fileManager): Response
    {
        $entity = new $this->entityName();
        $form = $this->createForm($this->formName, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uploadFile($fileManager, $form, $entity);
            $manager->save($entity);

            return $this->redirect("/{$this->className}/");
        }

        return $this->render("{$this->className}/new.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function show(Request $request, Manager $manager): Response
    {
        $id = $request->get('id');
        $entity = $this->getEntity($manager, $id);

        return $this->render("{$this->className}/show.html.twig", [
            'entity' => $entity
        ]);
    }

    /**
     * @Route("/{id}/edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Manager $manager, FileManager $fileManager): Response
    {
        $id = $request->get('id');
        $entity = $this->getEntity($manager, $id);

        $form = $this->createForm($this->formName, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uploadFile($fileManager, $form, $entity);
            $manager->save($entity);

            return $this->redirect("/{$this->className}/");
        }

        return $this->render("{$this->className}/edit.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", methods={"DELETE", "POST"})
     */
    public function delete(Request $request, Manager $manager): Response
    {
        $id = $request->get('id');
        $entity = $this->getEntity($manager, $id);

        if ($this->isCsrfTokenValid('delete'.$entity->getId(), $request->request->get('_token'))) {
            $manager->remove($entity);
        }

        return $this->redirect("/{$this->className}/");
    }

    /**
     * @param Manager $manager
     * @param int $id
     * 
     * @return Object
     */
    protected function getEntity($manager, $id): Object
    {
        return $manager->getRepository($this->entityName)->findOneBy(['id' => $id]);
    }

    /**
     * @param Foorm $form
     * @param $entity
     * 
     * @return void
     */
    protected function uploadFile(FileManager $fileManager, Form $form, $entity): void
    {
    }
}
