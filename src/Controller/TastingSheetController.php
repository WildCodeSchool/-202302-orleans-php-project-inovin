<?php

namespace App\Controller;

use App\Form\TastingSheetType;
use App\Entity\Session;
use App\Entity\TastingSheet;
use App\Repository\TastingSheetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TastingSheetController extends AbstractController
{
    #[Route('/ficheDeDegustation/{session}', name: 'app_tasting_sheet')]
    public function index(Request $request, TastingSheetRepository $tastingRepository, Session $session): Response
    {
        $tastingSheet = new tastingSheet();
        $form = $this->createForm(TastingSheetType::class, $tastingSheet);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            $tastingRepository->save($tastingSheet, true);
            // And redirect to a route that display the result
            return $this->redirectToRoute('app_tasting_sheet', ['session' => $session->getId()]);
        }

        return $this->render('tasting_sheet/index.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('ficheDeDegustation/{session}/result', name: 'app_tasting_sheet_result')]
    public function result(): Response
    {
        return $this->render('tasting_sheet/resultTastingSheet.html.twig', []);
    }
}
