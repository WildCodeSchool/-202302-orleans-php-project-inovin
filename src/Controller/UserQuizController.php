<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserQuiz;
use App\Form\QuizWineTypeType;
use App\Form\QuizKnowledgeType;
use App\Form\QuizWineColourType;
use App\Form\QuizWineRegionType;
use App\Repository\UserRepository;
use App\Repository\UserQuizRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user/quiz', name: 'app_user_quiz_')]
class UserQuizController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/connaissances_du_vin', name: 'one')]
    public function quizOne(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(QuizKnowledgeType::class);
        $form->handleRequest($request);

        /** @var \App\Entity\User */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form['options']->getData();
            $userRepository->save($user->setPreferences($data), true);
            return $this->redirectToRoute('app_user_quiz_two', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_quiz/knowledge.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/couleurs_favorites', name: 'two')]
    public function quizTwo(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(QuizWineColourType::class);
        $form->handleRequest($request);

        /** @var \App\Entity\User */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form['options']->getData();
            $userRepository->save($user->setPreferences($data), true);
            return $this->redirectToRoute('app_user_quiz_three', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_quiz/wine_colour.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/types_favoris', name: 'three')]
    public function quizThree(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(QuizWineTypeType::class);
        $form->handleRequest($request);

        /** @var \App\Entity\User */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form['options']->getData();
            $userRepository->save($user->setPreferences($data), true);

            return $this->redirectToRoute('app_user_quiz_four', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_quiz/wine_type.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/regions_favorites', name: 'four')]
    public function quizFour(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(QuizWineRegionType::class);
        $form->handleRequest($request);

        /** @var \App\Entity\User */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form['options']->getData();
            $userRepository->save($user->setPreferences($data), true);

            return $this->redirectToRoute('app_user_quiz_four', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_quiz/wine_region.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
