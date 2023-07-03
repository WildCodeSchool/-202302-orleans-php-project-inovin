<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\TastingSheet;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TastingSheetController extends AbstractController
{
    #[Route('/Degustation/{recipe}', name: 'app_tasting_sheet')]
    public function index(Request $request, RecipeRepository $recipeRepository, Recipe $recipe): Response
    {
        foreach ($recipe->getSession()->getWines() as $wine) {
            $tastingSheet = new TastingSheet();
            $tastingSheet->setWine($wine);
            $recipe->addTastingSheet($tastingSheet);
        }
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $recipeRepository->save($recipe, true);
            return $this->redirectToRoute('home_index');
        }
        return $this->render('tasting_sheet/index.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }
}
