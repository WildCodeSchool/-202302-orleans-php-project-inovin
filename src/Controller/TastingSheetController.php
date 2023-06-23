<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\TastingSheetType;
use App\Entity\TastingSheet;
use App\Repository\TastingSheetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TastingSheetController extends AbstractController
{
    #[Route('/ficheDeDegustation/{recipe}', name: 'app_tasting_sheet')]
    public function index(Request $request, TastingSheetRepository $tastingRepository, Recipe $recipe): Response
    {
        $tastingSheet1 = new tastingSheet();
        $tastingSheet2 = new tastingSheet();
        $tastingSheet3 = new tastingSheet();
        $tastingSheet4 = new tastingSheet();
        $form1 = $this->createForm(TastingSheetType::class, $tastingSheet1);
        $form2 = $this->createForm(TastingSheetType::class, $tastingSheet2);
        $form3 = $this->createForm(TastingSheetType::class, $tastingSheet3);
        $form4 = $this->createForm(TastingSheetType::class, $tastingSheet4);

        $form1->handleRequest($request);
        $form2->handleRequest($request);
        $form3->handleRequest($request);
        $form4->handleRequest($request);

        $wines = [];
        foreach ($recipe->getSession()->getWines() as $wine) {
            $wines[] = $wine;
        }

        if ($form1->isSubmitted()) {
            $tastingSheet1->setWine($wines[0]);
            $tastingSheet1->setRecipe($recipe);
            $tastingRepository->save($tastingSheet1, true);
            return $this->redirectToRoute('app_tasting_sheet', ['recipe' => $recipe->getId()]);
        }

        if ($form2->isSubmitted()) {
            $tastingSheet2->setWine($wines[1]);
            $tastingSheet2->setRecipe($recipe);

            $tastingRepository->save($tastingSheet2, true);
            return $this->redirectToRoute('app_tasting_sheet', ['recipe' => $recipe->getId()]);
        }
        if ($form3->isSubmitted()) {
            $tastingSheet3->setWine($wines[2]);
            $tastingSheet3->setRecipe($recipe);

            $tastingRepository->save($tastingSheet3, true);
            return $this->redirectToRoute('app_tasting_sheet', ['recipe' => $recipe->getId()]);
        }
        if ($form4->isSubmitted()) {
            $tastingSheet4->setWine($wines[3]);
            $tastingSheet4->setRecipe($recipe);

            $tastingRepository->save($tastingSheet4, true);
            return $this->redirectToRoute('app_tasting_sheet', ['recipe' => $recipe->getId()]);
        }

        return $this->render('tasting_sheet/index.html.twig', [
            'recipe' => $recipe,
            'form1' => $form1,
            'form2' => $form2,
            'form3' => $form3,
            'form4' => $form4,
        ]);
    }
}
