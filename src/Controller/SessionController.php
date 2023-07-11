<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Session;
use App\Entity\User;
use App\Form\SessionType;
use App\Repository\RecipeRepository;
use App\Repository\SessionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/seance', name: 'app_session_')]
class SessionController extends AbstractController
{
    #[Route('/etats/all', name: 'all_states', methods: ['GET'])]
    public function states(SessionRepository $sessionRepository): Response
    {
        $sessionsOpened = $sessionRepository->getNextOpenedSessions();
        $firstOpenedSession = (count($sessionsOpened) === 0 ? [] :  [$sessionsOpened[0]]);
        $nextOpenedSessions = count($sessionsOpened) > 1 ? array_splice($sessionsOpened, 1) : [];
        $closedSessions = $sessionRepository->findBy(['closed' => true], ['openingDate' => 'desc',]);

        return $this->render('admin/session/sessions_states.html.twig', [
            'firstOpenedSession' => $firstOpenedSession,
            'nextSessions' => $nextOpenedSessions,
            'closedSessions' => $closedSessions
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/start/{session}', requirements: ['session' => '\d+'], methods: ['GET'], name: 'start_new')]
    public function startSession(
        Session $session,
        RecipeRepository $recipeRepository,
        Security $security
    ): RedirectResponse {
        /** @var User $user */
        $user = $security->getUser();
        $recipe = $recipeRepository->findOneBy(['session' => $session->getId(), 'user' => $user->getId()]);
        if (!isset($recipe)) {
            $recipe = new Recipe();
            $recipe->setName('Recette - ' .  $user->getFirstname() . ' - ' . date('Y-m-d-hhii'));
            $recipe->setSession($session);
            $recipe->setUser($user);
            $recipe->setSessionRate(0);
            $recipeRepository->save($recipe, true);
        }

        return $this->redirectToRoute('app_tasting_sheet', ['recipe' => $recipe->getId()]);
    }
}
