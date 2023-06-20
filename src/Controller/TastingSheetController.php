<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TastingSheetController extends AbstractController
{
    #[Route('/ficheDeDegustation/{session}', name: 'app_tasting_sheet')]
    public function index(Session $session): Response
    {
        return $this->render('tasting_sheet/index.html.twig', [
            'session' => $session,
        ]);
    }
}
