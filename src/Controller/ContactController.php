<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer, Contact $contact): Response
    {
        $contact = new contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($contact->getEmail())
                ->to($this->getParameter('mailer_from'))
                ->subject($contact->getSubject())
                ->html($this->renderView('contact/emailContact.html.twig', ['contact' => $contact]));

            $mailer->send($email);
            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
