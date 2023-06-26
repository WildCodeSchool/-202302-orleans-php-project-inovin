<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Form\Search\SearchWineDataFormType;
use App\Repository\WineRepository;
use App\Search\SearchWineData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vin', name: 'app_wine_')]
class WineController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request, WineRepository $wineRepository): Response
    {
        $searchWineData = new SearchWineData();
        $form = $this->createForm(SearchWineDataFormType::class, $searchWineData);
        $form->handleRequest($request);

        $wines = $wineRepository->findSearch($searchWineData, ['name' => 'ASC']);

        return $this->render('wine/index.html.twig', [
            'wines' => $wines,
            'form' =>  $form
        ]);
    }
}
