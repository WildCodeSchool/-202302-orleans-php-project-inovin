<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\TastingSheet;
use App\Form\TastingSheetType;
use App\Repository\TastingSheetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'recipe')]
    public function index(
        Request $request,
        TastingSheetRepository $tastingSheetRepo
    ): Response {
        $tastingSheet = new TastingSheet();
        $form = $this->createForm(TastingSheetType::class, $tastingSheet);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            $tastingSheetRepo->save($tastingSheet, true);
            // And redirect to a route that display the result
            return $this->redirectToRoute('app_tasting_sheet');
        }

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
            'form' => $form,
        ]);
    }
}
