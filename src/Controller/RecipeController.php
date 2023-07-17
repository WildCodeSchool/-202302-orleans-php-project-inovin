<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType;
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
        /** @var User $user */
        $user = $this->getUser();
        $recipes = $user->getRecipes();

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
            'containerReference' => self::CONTAINER_REF
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/recette/{id}/resultat', name: 'result_recipe')]
    public function editRecipe(
        Request $request,
        Recipe $recipe,
        TastingSheet $tastingSheet,
        TastingSheetRepository $tastingSheetRepo,
    ): Response {
        $currentUser = $this->getUser();
        if ($currentUser !== $recipe->getUser()) {
            throw $this->createAccessDeniedException(
                "Accès refusé. Vous n'êtes pas autorisé à accéder à cette recette."
            );
        }

        $form = $this->createForm(FinalRecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tastingSheetRepo->save($tastingSheet, true);
        }

        return $this->render('recipe/resultat.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }
}
