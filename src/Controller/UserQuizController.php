<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserPreference;
use App\Form\QuizIntroductionType;
use App\Repository\UserPreferenceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user/quiz', name: 'app_user_quiz_')]
class UserQuizController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'quiz')]
    public function quizOne(Request $request, UserPreferenceRepository $userPrefRepo): Response
    {

        /** @var User $user */
        $user = $this->getUser();

        $userPreference = $user->getUserPreference() ?? (new UserPreference())->setUser($user);

        $form = $this->createForm(QuizIntroductionType::class, $userPreference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userPrefRepo->save($userPreference, true);

            return $this->redirectToRoute('app_user_quiz_recap', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_quiz/knowledge.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/recapitulatif', name: 'recap')]
    public function quizRecap(UserPreferenceRepository $userPrefRepo): Response
    {
        return $this->render('user_quiz/recap.html.twig');
    }
}
