<?php

namespace App\Service;

use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class TaskManager
{
    private $manager;
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $manager)
    {
        $this->formFactory = $formFactory;
        $this->manager = $manager;
    }

    public function create($task, $user)
    {
        $task->setIsDone(false);
        $task->setUser($user);

        $this->persist($task);
    }

    public function edit($task)
    {
        $this->persist($task);
    }

    public function isDone($task)
    {
        $task->setIsDone(true);

        $this->persist($task);
    }

    public function form($task, $request)
    {
        $form = $this->formFactory->create(TaskType::class, $task);

        $form->handleRequest($request);

        return $form;
    }

    public function noDone($task)
    {
        $task->setIsDone(false);

        $this->persist($task);
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
