<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Session;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType;
use App\Repository\TastingSheetRepository;
use App\Service\CalculateWineDosageService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    #[Route('/recette/{id}/resultat', name: 'result_recipe')]
    public function index(Recipe $recipe, CalculateWineDosageService $calculateWineDosage): Response
    {
        return $this->render('recipe/recipeResult.html.twig', [
            'recipe' => $recipe,
            'dosage' => $calculateWineDosage,
        ]);
    }
}
