<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Form\WineType;
use App\Repository\WineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vin')]
class WineController extends AbstractController
{
    #[Route('/', name: 'app_wine_index', methods: ['GET'])]
    public function index(WineRepository $wineRepository): Response
    {
        return $this->render('wine/index.html.twig', [
            'wines' => $wineRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_wine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WineRepository $wineRepository): Response
    {
        $wine = new Wine();
        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wineRepository->save($wine, true);

            $this->addFlash(
                'success',
                'Le Vin a été ajouté'
            );
            return $this->redirectToRoute('app_wine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wine/new.html.twig', [
            'wine' => $wine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wine_show', methods: ['GET'])]
    public function show(Wine $wine): Response
    {
        return $this->render('wine/show.html.twig', [
            'wine' => $wine,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_wine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Wine $wine, WineRepository $wineRepository): Response
    {
        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wineRepository->save($wine, true);

            return $this->redirectToRoute('app_wine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wine/edit.html.twig', [
            'wine' => $wine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_wine_delete', methods: ['POST'])]
    public function delete(Request $request, Wine $wine, WineRepository $wineRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $wine->getId(), $request->request->get('_token'))) {
            $wineRepository->remove($wine, true);
        }

        return $this->redirectToRoute('app_wine_index', [], Response::HTTP_SEE_OTHER);
    }
}
