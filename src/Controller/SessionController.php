<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/session')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'admin_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findBy([], ['openingDate' => 'desc',]);

        return $this->render('admin/session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }

    #[Route('/new', name: 'admin_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SessionRepository $sessionRepository): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionRepository->save($session, true);
            $this->addFlash('success', 'La séance a bien été ajoutée');

            return $this->redirectToRoute('admin_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/session/new.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_session_show', methods: ['GET'])]
    public function show(Session $session): Response
    {
        return $this->render('admin/session/show.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, SessionRepository $sessionRepository): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionRepository->save($session, true);
            $this->addFlash('success', 'La séance a bien été modifiée');

            return $this->redirectToRoute('admin_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/session/edit.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, SessionRepository $sessionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
            $sessionRepository->remove($session, true);
            $this->addFlash('success', 'La séance a bien été supprimée');
        }

        return $this->redirectToRoute('admin_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
