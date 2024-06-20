<?php
// src/Controller/RecetteController.php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\IngredientsRepository;
use App\Repository\QuantityRepository;
use App\Repository\RecetteRepository;
use App\Repository\TagsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RecetteController extends AbstractController
{
    #[Route('/recette', name: 'admin_recette')]
    public function index(
        RecetteRepository $recetteRepository,
        PaginatorInterface $paginator,
        Request $request,AuthorizationCheckerInterface $authorizationChecker,
        IngredientsRepository $ingredientRepository,
        TagsRepository $tagsRepository
    ): Response {
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
            return $this->render('access_denied.html.twig');
        }
        $recettes = $paginator->paginate(
            $recetteRepository->findAll(),
            $request->query->getInt('page', 1),
            4
        );
        $ingredients = $paginator->paginate(
            $ingredientRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('recette/index.html.twig', [
            'recettes' => $recettes,
            'ingredients' => $ingredients,
        ]);
    }

    #[Route('/recette/create', name: 'create_recette')]
    public function recetteCreate(
        Request $request,AuthorizationCheckerInterface $authorizationChecker,
        EntityManagerInterface $manager
    ): Response {
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
            return $this->render('access_denied.html.twig');
        }
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($recette);
            $manager->flush();

            $this->addFlash('success', 'Une recette a été créée avec succès!');
            return $this->redirectToRoute('create_quantity', ['recetteId' => $recette->getId()]);
        }

        return $this->render('recette/create.html.twig', [
            'button' => 'Soumettre',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recette/edit/{id}', name: 'edit_recette', methods: ['GET', 'POST'])]
    public function recetteEdit(
        RecetteRepository $recetteRepository,
        int $id,AuthorizationCheckerInterface $authorizationChecker,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
            return $this->render('access_denied.html.twig');
        }
        $recette = $recetteRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();

            $manager->persist($recette);
            $manager->flush();
            $this->addFlash('success', 'La recette ' . $id . ' a été modifiée avec succès!');
            return $this->redirectToRoute('admin_recette');
        }

        return $this->render('recette/edit.html.twig', [
            'button' => 'Soumettre',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recette/delete/{id}', name: 'delete_recette', methods: ['GET', 'POST'])]
    public function delete(
        int $id,
        EntityManagerInterface $manager,AuthorizationCheckerInterface $authorizationChecker,
        RecetteRepository $recetteRepository
    ): Response {
        if (!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
            return $this->render('access_denied.html.twig');
        }
        $recette = $recetteRepository->find($id);
        if (!$recette) {
            throw $this->createNotFoundException('Aucune recette trouvée pour l\'id ' . $id);
        }

        // Supprimer les quantités associées manuellement
        foreach ($recette->getQuantities() as $quantity) {
            $manager->remove($quantity);
        }

        $manager->remove($recette);
        $manager->flush();

        $this->addFlash('success', 'Recette supprimée avec succès!');
        return $this->redirectToRoute('admin_recette');
    }

    #[Route('/recette/{id}', name: 'recette_show')]
    public function show(int $id, RecetteRepository $recetteRepository): Response
    {
        $recette = $recetteRepository->find($id);

        if (!$recette) {
            throw $this->createNotFoundException('Aucune recette trouvée pour l\'id ' . $id);
        }

        return $this->render('recette/show.html.twig', [
            'recette' => $recette,
            'ingredients' => $recette->getIngredients(),
            'tags' => $recette->getTags(),
        ]);
    }
}
