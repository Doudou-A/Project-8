<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskListController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(TaskRepository $repo)
    {
        $tasks = $repo->findAll();

        return $this->render(
            'task/list.html.twig',
            ['tasks' => $tasks]
        );
    }
}