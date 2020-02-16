<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskListFinishController extends AbstractController
{

    /**
     * @Route("/tasks-finish", name="task_list_finish")
     */
    public function listActionFinish(TaskRepository $repo)
    {
        $tasks = $repo->findByisDone(true);

        return $this->render(
            'task/list.html.twig',
            ['tasks' => $tasks]
        );
    }
}