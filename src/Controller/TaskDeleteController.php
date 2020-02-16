<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\TaskManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskDeleteController extends AbstractController
{
    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, TaskManager $taskManager)
    {
        $user = $this->getUser();

        $taskManager->delete($task, $user);

        return $this->redirectToRoute('task_list');
    }
}
