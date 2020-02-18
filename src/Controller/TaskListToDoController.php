<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskListToDoController extends AbstractController
{
    /**
     * @Route("/tasks-ToDO", name="task_list_todo")
     */
    public function listActionToDO(TaskRepository $repo)
    {
        $tasks = $repo->findByisDone(false);

        return $this->render(
            'task/list.html.twig',
            ['tasks' => $tasks]
        );
    }
}