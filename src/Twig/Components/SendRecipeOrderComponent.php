<?php

namespace App\Twig\Components;

use App\Entity\Recipe;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent()]
class SendRecipeOrderComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public int $nbrSendOrder = 0;

    #[LiveProp]
    public ?Recipe $recipe = null;

    private string $fromEmailAdress;

    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params
    ) {
        $this->fromEmailAdress = $this->params->get('mailer_from');
    }

    #[LiveAction]
    public function sendOrderByMail(): void
    {
        /** @var User $user */
        $user = $this->getUser();
        try {
            $email = (new TemplatedEmail())
                ->from(new Address($this->fromEmailAdress, 'InoVin-Shop'))
                ->to($user->getEmail())
                ->subject("Commande d\'une recette")
                ->htmlTemplate('recipe/email/emailRecipeOrder.html.twig')
                ->context(['user' => $user, 'recipe' => $this->recipe]);
            $this->mailer->send($email);
            $this->nbrSendOrder++;
        } catch (TransportExceptionInterface $ex) {
            $this->addFlash('error', $ex->getMessage());
        }
    }
}
