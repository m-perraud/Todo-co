<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $getDoctrine
    )
    {

    }

    #[Route('/task', name: 'task_list')]
    public function index(): Response
    {
        
        return $this->render('task/list.html.twig', 
        ['tasks' => $this->getDoctrine->getRepository(Task::class)->findAll()]);
    }

    #[Route('/task/create', name: 'task_create')]
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine;
            $task->setAuthor($this->getUser());

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', 
        ['form' => $form->createView()]);
    }

    #[Route('/task/{id}/edit', name: 'task_edit')]
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/task/{id}/toggle', name: 'task_toggle')]
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isIsDone());
        $this->getDoctrine->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/task/{id}/delete', name: 'task_delete')]
    public function deleteTaskAction(Task $task)
    {
        if ($this->getUser() == $task->getAuthor() || $task->getAuthor()->getUsername() == 'anonyme' && $this->isGranted('ROLE_ADMIN'))
        {
            $em = $this->getDoctrine;
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');
        } else {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer une tâche qui ne vous appartient pas.');
        }

        return $this->redirectToRoute('task_list');
    }
}
