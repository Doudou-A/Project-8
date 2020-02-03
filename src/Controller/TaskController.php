<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Service\TaskManager;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
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

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(TaskManager $taskManager, Request $request)
    {
        $task = new Task();

        $form = $taskManager->form($task, $request, 'create');

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, TaskManager $taskManager, Request $request)
    {
        $form = $taskManager->form($task, $request, 'edit');

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task, TaskManager $taskManager)
    {
        if ($task->getIsDone() == false) {
            $taskManager->isDone($task);
        } else {
            $taskManager->noDone($task);
        }

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, TaskManager $taskManager)
    {
        $taskManager->delete($task);

        return $this->redirectToRoute('task_list');
    }
}
