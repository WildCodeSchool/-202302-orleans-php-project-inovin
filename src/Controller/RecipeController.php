<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Session;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType;
use App\Repository\RecipeRepository;
use App\Repository\TastingSheetRepository;
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
        /*  dd($recipes); */
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes, 'containerReference' => self::CONTAINER_REF
        ]);
    }

    #[Route('/recette/resultat/{id}', name: 'recipe_result')]
    public function recipeResult(Recipe $recipe): Response
    {

        return $this->render('recipe/resultat.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}
