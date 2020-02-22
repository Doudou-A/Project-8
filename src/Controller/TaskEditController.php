<?php

namespace App\Controller;

use App\Entity\Task;
use App\Service\TaskManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskEditController extends AbstractController
{

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, TaskManager $taskManager, Request $request)
    {
        $form = $taskManager->form($task, $request);

        if ($form->isSubmitted() && $form->isValid()) {

            $taskManager->edit($task);

            $this->addFlash('success', 'La tâche a été bien été modifiée !');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }
}
