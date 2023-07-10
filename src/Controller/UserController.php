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
            $this->addFlash("success", "Vos informations ont été modifiées !");
            return $this->redirectToRoute('user_profile_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_profile/userProfile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
