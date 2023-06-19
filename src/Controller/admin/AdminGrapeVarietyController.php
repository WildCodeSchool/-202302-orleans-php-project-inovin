<?php

namespace App\Controller\admin;

use App\Entity\GrapeVariety;
use App\Form\GrapeVarietyType;
use App\Repository\GrapeVarietyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cepage', name: 'app_admin_cepage_')]
class AdminGrapeVarietyController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(GrapeVarietyRepository $grapeRepository): Response
    {
        return $this->render('admin/grape_variety/index.html.twig', [
            'grape_varieties' => $grapeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, GrapeVarietyRepository $grapeRepository): Response
    {
        $grapeVariety = new GrapeVariety();
        $form = $this->createForm(GrapeVarietyType::class, $grapeVariety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grapeRepository->save($grapeVariety, true);

            $this->addFlash(
                'success',
                'Le cépage a été ajouté'
            );

            return $this->redirectToRoute('app_admin_cepage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/grape_variety/new.html.twig', [
            'grape_variety' => $grapeVariety,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(GrapeVariety $grapeVariety): Response
    {
        return $this->render('admin/grape_variety/show.html.twig', [
            'grape_variety' => $grapeVariety,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        GrapeVariety $grapeVariety,
        GrapeVarietyRepository $grapeRepository
    ): Response {
        $form = $this->createForm(GrapeVarietyType::class, $grapeVariety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grapeRepository->save($grapeVariety, true);
            $this->addFlash("success", "Modifications du cépage effectuées !");
            return $this->redirectToRoute('app_admin_cepage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/grape_variety/edit.html.twig', [
            'grape_variety' => $grapeVariety,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        GrapeVariety $grapeVariety,
        GrapeVarietyRepository $grapeRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $grapeVariety->getId(), $request->request->get('_token'))) {
            $grapeRepository->remove($grapeVariety, true);
        }
        return $this->redirectToRoute('app_admin_cepage_index', [], Response::HTTP_SEE_OTHER);
    }
}
