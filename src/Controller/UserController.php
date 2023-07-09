<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[Route('/user', name: 'user_profile_')]
class UserController extends AbstractController
{
    #[Route('/profil/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function showProfile(
        Request $request,
        User $user,
        UserRepository $userRepository,
    ): Response {
        $currentUser = $this->getUser();
        if ($currentUser !== $user) {
            throw $this->createAccessDeniedException("Accès refusé. Vous n'êtes pas autorisé à accéder à ce profil.");
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            $this->addFlash("success", "Vos informations ont été sauvegardées !");
            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_profile/userProfile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/profil/{id}', name: 'delete', methods: ['POST'])]
    public function deleteProfile(
        Request $request,
        User $user,
        UserRepository $userRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            dd('coucou');
        }
        return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
    }
}
