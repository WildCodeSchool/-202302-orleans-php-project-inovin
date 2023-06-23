<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Repository\WineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vin', name: 'app_wine_')]
class WineController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(WineRepository $wineRepository): Response
    {
        return $this->render('wine/index.html.twig', [
            'wines' => $wineRepository->findBy([], ['name' => 'ASC']),
        ]);
    }
}
