<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Wine;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

#[IsGranted('ROLE_USER')]
class SendOrderService
{
    private string $fromEmailAdress;

    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params,
        private Security $security
    ) {
        $this->fromEmailAdress = $this->params->get('mailer_from');
    }

    public function sendOrder(Wine $wine): bool
    {
        /** @var User $user */
        $user = $this->security->getUser();

        try {
            $email = (new TemplatedEmail())
                ->from(new Address($this->fromEmailAdress, 'InoVin-Shop'))
                ->to($user->getEmail())
                ->subject("Commande de vin")
                ->htmlTemplate('wine/email/emailWineOrder.html.twig')
                ->context(['user' => $user, 'wine' => $wine]);

            $this->mailer->send($email);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
