<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Session;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\RecipeRepository;
use App\Repository\TastingSheetRepository;
use App\Service\CalculateWineDosageService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    #[Route('/recette/show/{id}', name: 'recipe_show')]
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
            'containerReference' => self::CONTAINER_REF
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/recette/user', name: 'recipe_user')]
    public function recipeUser(): Response
    {
        return $this->render('recipe/recipeUser.html.twig', [
            'containerReference' => self::CONTAINER_REF
        ]);
    }

    #[Route('/recette/{id}/resultat', name: 'result_recipe')]
    public function recipeResult(Recipe $recipe, CalculateWineDosageService $calculateWineDosage): Response
    {
        return $this->render('recipe/recipeResult.html.twig', [
            'recipe' => $recipe,
            'dosage' => $calculateWineDosage,
        ]);
    }
}
