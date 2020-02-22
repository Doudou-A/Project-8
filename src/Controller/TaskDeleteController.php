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

        $userTask = $task->getUser();

        $role = $user->getRoles()[0];
        
        if ($userTask == null AND $role == "ROLE_ADMIN" OR $userTask == $user) {

            $taskManager->remove($task);
            $this->addFlash('success', 'La tâche a bien été supprimée !');

        } else {

            $this->addFlash('error', sprintf('Vous n\'êtes pas autorisé à supprimer la tâche %s !' , $task->getTitle()));
        }
        return $this->redirectToRoute('task_list');
    }
}
