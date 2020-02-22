<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\TaskManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskToggleController extends AbstractController
{
    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task, TaskManager $taskManager)
    {
        if ($task->getIsDone() == false) {
            
            $taskManager->isDone($task);

            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
            
        } else {

            $taskManager->noDone($task);

            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme non faite.', $task->getTitle()));
            
        }

        return $this->redirectToRoute('task_list');
    }
}