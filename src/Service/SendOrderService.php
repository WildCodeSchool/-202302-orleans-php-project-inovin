<?php

namespace App\Service;

use App\Entity\Recipe;
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

    public function sendOrder(object $object): bool
    {
        /** @var User $user */
        $user = $this->security->getUser();

        try {
            $email = (new TemplatedEmail())
                ->from(new Address($this->fromEmailAdress, 'InoVin-Shop'))
                ->to($user->getEmail())
                ->subject(($object instanceof Wine) ? "Commande de vin" : "Commande d\'une recette")
                ->htmlTemplate(
                    ($object instanceof Wine) ?
                        'wine/email/emailWineOrder.html.twig'
                        : 'recipe/email/emailRecipeOrder.html.twig'
                )
                ->context(['user' => $user, 'object' => $object]);
            $this->mailer->send($email);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
