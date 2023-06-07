<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()/*  && $form->isValid() */) {
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($_POST['contact_form']['email'])
                ->subject('INOVIN - Nous avons bien reçu votre Email')
                ->html('<p>Nos conseillés font leur possible pour vous 
                répondre le plus vite possible, merci de votre patience</p>');

            $mailer->send($email);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
