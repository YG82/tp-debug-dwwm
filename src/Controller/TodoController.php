<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoFormType;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TodoController extends AbstractController
{
    public function __construct(
        private TodoRepository $tr,
        private EntityManagerInterface $em,
    ){}

    #[Route('/todos', name: 'todos_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('todo/index.html.twig', [
            'todos' => $this->tr->findByCreator($this->getUser()),
        ]);
    }
    
    #[Route('/todos/add', name: 'todos_add', methods: ['GET', 'POST'])]
    public function add(Request $request): Response
    {
        $todo = new Todo();
        $form = $this->createForm(TodoFormType::class, $todo);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todo->setCreator($this->getUser());
            $this->em->persist($todo);
            $this->em->flush();

            $this->addFlash('success', 'La tâche a bien été créée');
            return $this->redirectToRoute('todos_index');
        }

        return $this->render('todo/form.html.twig', [
            'todoForm' => $form,
            'pageTitle' => 'Ajouter une liste',
            'pageSubtitle' => 'Créons une nouvelle liste de chose à faire',
        ]);
    }
    
    #[Route('/todos/edit/{ref}', name: 'todos_edit', methods: ['GET', 'POST'])]
    public function edit(string $ref): Response
    {
        $todo = $this->tr->findOneByRef($ref);

        if($todo->getCreator() != $this->getUser()){
            $this->addFlash('danger', 'Cette tâche ne vous appartient pas');
            return $this->redirectToRoute('todos_index');
        }

        $form = $this->createForm(TodoFormType::class, $todo);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($todo);
            $this->em->flush();

            $this->addFlash('success', 'La tâche a bien été mise à jour');
            return $this->redirectToRoute('todos_show', [ 'ref' => $ref ]);
        }

        return $this->render('todo/form.html.twig', [
            'todoForm' => $form,
            'pageTitle' => 'Modifier une liste',
            'pageSubtitle' => 'Ajustons un peu les choses à faire',
        ]);
    }
    
    #[Route('/todos/{ref}', name: 'todos_show', methods: ['GET'])]
    public function show(string $ref): Response
    {
        return $this->render('todo/show.html.twig', [
            'todo' => $this->tr->findOneByRef($ref),
        ]);
    }

    #[Route('/todos/delete/{ref}', name: 'todos_delete', methods: ['POST'])]
    public function delete(string $ref): Response
    {
        $todo = $this->tr->findOneByRef($ref);

        if($todo->getCreator() == $this->getUser()){
            $this->em->remove($todo);
            $this->em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée');
        } else {
            $this->addFlash('danger', 'Cette tâche ne vous appartient pas');
        }

        return $this->redirectToRoute('todos');
    }
}
