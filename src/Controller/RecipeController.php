<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\TastingSheet;
use App\Form\FinalRecipeType;
use App\Repository\RecipeRepository;
use App\Repository\TastingSheetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    #[IsGranted('ROLE_USER')]
    #[Route('/recette/user', name: 'recipe_user')]
    public function recipeUser(): Response
    {
        return $this->render('recipe/recipeUser.html.twig', [
            'containerReference' => self::CONTAINER_REF
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/recette/{id}/resultat', name: 'result_recipe')]
    public function editRecipe(
        Request $request,
        Recipe $recipe,
        TastingSheet $tastingSheet,
        TastingSheetRepository $tastingSheetRepo
    ): Response {
        $form = $this->createForm(FinalRecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tastingSheetRepo->save($tastingSheet, true);
            $this->addFlash("success", "Vos dosages ont été modifiés !");

            return $this->redirectToRoute('result_recipe', ['id' => $recipe->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recipe/resultat.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
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
