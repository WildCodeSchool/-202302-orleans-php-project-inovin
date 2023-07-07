<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\TastingSheet;
use App\Form\RecipeTastingSheetType;
use App\Repository\RecipeRepository;
use App\Repository\TastingSheetRepository;
use App\Service\CalculateWineDosageService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TastingSheetController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/degustation/{recipe}', name: 'app_tasting_sheet')]
    public function index(Request $request, RecipeRepository $recipeRepository, Recipe $recipe): Response
    {
        foreach ($recipe->getSession()->getWines() as $wine) {
            $tastingSheet = new TastingSheet();
            $tastingSheet->setWine($wine);
            $recipe->addTastingSheet($tastingSheet);
        }
        $form = $this->createForm(RecipeTastingSheetType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $recipeRepository->save($recipe, true);
            return $this->redirectToRoute('app_tasting_sheet_result', ['recipe' => $recipe->getId()]);
        }
        return $this->render('tasting_sheet/index.html.twig', [
            'recipe' => $recipe,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('degustation/{recipe}/resultat', name: 'app_tasting_sheet_result')]
    public function result(
        Recipe $recipe,
        CalculateWineDosageService $calculWineDosageSrv,
        TastingSheetRepository $tastingRepository
    ): Response {

        $resultDosages = $calculWineDosageSrv->calculate($recipe);

        foreach ($resultDosages as $itemDosage) {
            foreach ($recipe->getTastingSheet() as $itemTastingSheet) {
                if ($itemTastingSheet->getId() === $itemDosage['tastingSheet_id']) {
                    $itemTastingSheet->setDosage($itemDosage['dosage']);
                    $tastingRepository->save($itemTastingSheet, true);
                    continue;
                }
            }
        }

        return $this->render('tasting_sheet/resultTastingSheet.html.twig', [
            'recipe' => $recipe,
        ]);
    }
}
