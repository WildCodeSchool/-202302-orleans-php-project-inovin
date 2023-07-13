<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Entity\Wine;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent()]
class SendWineOrderComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public int $nbrSendOrder = 0;

    #[LiveProp]
    public ?Wine $wine = null;

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
                ->subject("Commande de vin")
                ->htmlTemplate('wine/email/emailWineOrder.html.twig')
                ->context(['user' => $user, 'wine' => $this->wine]);
            $this->mailer->send($email);
            $this->nbrSendOrder++;
        } catch (TransportExceptionInterface $ex) {
            $this->addFlash('error', $ex->getMessage());
        }
    }
}
