<?php

namespace App\Service;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

class TaskManager
{
    private $container;
    private $manager;
    private $repo;
    private $request;
    private $formFactory;

    public function __construct(ContainerInterface $container, FormFactoryInterface $formFactory, EntityManagerInterface $manager, TaskRepository $repo, Request $request)
    {
        $this->container = $container;
        $this->formFactory = $formFactory;
        $this->manager = $manager;
        $this->repo = $repo;
        $this->request = $request;
    }

    public function addFlash($type, $message)
    {
        $this->container->get('session')->getFlashBag()->add($type, $message);
    }

    public function create($task)
    {
        $user = $this->getUser();
        $task->setIsDone(false);
        $task->setUser($user);

        $this->persist($task);
    }

    public function delete($task){
        $user = $this->getUser();
        $userTask = $task->getUser();
        $role = $user->getRoles()[0];

        if ($userTask == null AND $role == "ROLE_ADMIN" OR $userTask == $user) {

            $this->remove($task);
            $this->addFlash('success', 'La tâche a bien été supprimée.');

        } else {

            $this->addFlash('error', sprintf('Vous n\'êtes pas autorisé à supprimer la tâche %s !' , $task->getTitle()));
        }
    }

    public function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return null;
        }

        if (!\is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }

    public function isDone($task)
    {
        $task->setIsDone(true);

        $this->persist($task);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
    }

    public function form($task, $request, $action)
    {
        $form = $this->formFactory->create(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($action == 'create') {
                $this->create($task);
                $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            }elseif($action == 'edit'){
                $this->persist($task);
                $this->addFlash('success', 'La tâche a été bien été modifiée.');
            }
           
        }

        return $form;
    }

    public function noDone($task)
    {
        $task->setIsDone(false);

        $this->persist($task);

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non faite.', $task->getTitle()));
    }

    public function persist($entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }

    public function remove($entity)
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }
}
