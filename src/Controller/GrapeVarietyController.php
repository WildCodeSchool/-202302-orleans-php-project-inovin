<?php

namespace App\Controller;

use App\Entity\GrapeVariety;
use App\Form\GrapeVarietyType;
use App\Repository\GrapeVarietyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/grape/variety')]
class GrapeVarietyController extends AbstractController
{
    #[Route('/', name: 'app_grape_variety_index', methods: ['GET'])]
    public function index(GrapeVarietyRepository $grapeVarietyRepository): Response
    {
        return $this->render('grape_variety/index.html.twig', [
            'grape_varieties' => $grapeVarietyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_grape_variety_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GrapeVarietyRepository $grapeVarietyRepository): Response
    {
        $grapeVariety = new GrapeVariety();
        $form = $this->createForm(GrapeVarietyType::class, $grapeVariety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grapeVarietyRepository->save($grapeVariety, true);

            return $this->redirectToRoute('app_grape_variety_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grape_variety/new.html.twig', [
            'grape_variety' => $grapeVariety,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grape_variety_show', methods: ['GET'])]
    public function show(GrapeVariety $grapeVariety): Response
    {
        return $this->render('grape_variety/show.html.twig', [
            'grape_variety' => $grapeVariety,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_grape_variety_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GrapeVariety $grapeVariety, GrapeVarietyRepository $grapeVarietyRepository): Response
    {
        $form = $this->createForm(GrapeVarietyType::class, $grapeVariety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grapeVarietyRepository->save($grapeVariety, true);

            return $this->redirectToRoute('app_grape_variety_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grape_variety/edit.html.twig', [
            'grape_variety' => $grapeVariety,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grape_variety_delete', methods: ['POST'])]
    public function delete(Request $request, GrapeVariety $grapeVariety, GrapeVarietyRepository $grapeVarietyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grapeVariety->getId(), $request->request->get('_token'))) {
            $grapeVarietyRepository->remove($grapeVariety, true);
        }

        return $this->redirectToRoute('app_grape_variety_index', [], Response::HTTP_SEE_OTHER);
    }
}
