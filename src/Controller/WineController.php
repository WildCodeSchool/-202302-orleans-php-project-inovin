<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wine;
use App\Form\Search\SearchWineDataFormType;
use App\Repository\WineRepository;
use App\Search\SearchWineData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RequestStack;

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

    #[Route('/{id}', name: 'show')]
    public function show(Wine $wine): Response
    {
        return $this->render('wine/show.html.twig', [
            'wine' => $wine,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/recette/user/favorites', name: 'favorites')]
    public function favoritesRecipeUser(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $wines = $user->getFavoritesWines();

        return $this->render('wine/favoritesWines.html.twig', [
            'wines' => $wines,
        ]);
    }
}
