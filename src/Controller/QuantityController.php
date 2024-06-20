<?php

// src/Controller/QuantityController.php

namespace App\Controller;

use App\Entity\Quantity;
use App\Form\QuantityType;
use App\Repository\IngredientsRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuantityController extends AbstractController
{
    #[Route('/quantite/create/{recetteId}', name: 'create_quantity')]
    public function quantityCreate(
        int $recetteId,
        Request $request,
        EntityManagerInterface $manager,
        RecetteRepository $recetteRepository,
        IngredientsRepository $ingredientsRepository
    ): Response {
        $recette = $recetteRepository->find($recetteId);

        if (!$recette) {
            throw $this->createNotFoundException('Aucune recette trouvée pour l\'id ' . $recetteId);
        }

        $quantities = [];
        foreach ($recette->getIngredients() as $ingredient) {
            $quantity = new Quantity();
            $quantity->setRecette($recette);
            $quantity->setIngredients($ingredient);
            $quantities[] = $quantity;
        }

        $form = $this->createForm(QuantityType::class, ['quantities' => $quantities]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('quantities')->getData() as $quantity) {
                $manager->persist($quantity);
            }
            $manager->flush();

            // $this->addFlash('success', 'Les quantités ont été créées avec succès!');
            return $this->redirectToRoute('recette');
        }

        return $this->render('recette/quantite.html.twig', [
            'button' => 'Soumettre',
            'form' => $form->createView(),
        ]);
    }
}
