<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Session;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType;
use App\Repository\RecipeRepository;
use App\Repository\TastingSheetRepository;
use App\Service\CalculateWineDosageService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    public const CONTAINER_REF = 250;
    #[Route('/recette', name: 'recipe_index')]
    public function index(RecipeRepository $recipeRepository): Response
    {
        $recipes = $recipeRepository->findAll();
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes, 'containerReference' => self::CONTAINER_REF
        ]);
    }

    #[Route('/recette/{id}/resultat', name: 'result_recipe')]
    public function recipeResult(Recipe $recipe, CalculateWineDosageService $calculateWineDosage): Response
    {
        return $this->render('recipe/resultat.html.twig', [
            'recipe' => $recipe,
            'dosage' => $calculateWineDosage,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/recette/{id}/resultat/final', name: 'result_recipe_final')]
    public function recipeResultFinal(
        Recipe $recipe,
        TastingSheet $tastingSheet,
    ): Response {
        return $this->render('recipe/finalRecipe.html.twig', [
            'recipe' => $recipe,
            'containerReference' => self::CONTAINER_REF,
            'tastingSheet' => $tastingSheet,
        ]);
    }
}
