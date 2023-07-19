<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $getDoctrine
    ) {
    }

    #[Route('/task', name: 'task_list')]
    public function tasksList(): Response
    {
        return $this->render('task/list.html.twig',
            ['tasks' => $this->getDoctrine->getRepository(Task::class)->findAll()]);
    }

    #[Route('/task/create', name: 'task_create')]
    public function createTask(Request $request): Response
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
    public function editTask(Task $task, Request $request): Response
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
    public function toggleTaskStatus(Task $task): RedirectResponse
    {
        $task->toggle(!$task->isIsDone());
        $this->getDoctrine->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/task/{id}/delete', name: 'task_delete')]
    public function deleteTask(Task $task): RedirectResponse
    {
        if ($this->getUser() == $task->getAuthor() || 'anonyme' == $task->getAuthor()->getUsername() && $this->isGranted('ROLE_ADMIN')) {
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
