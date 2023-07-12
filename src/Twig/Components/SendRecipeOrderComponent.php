<?php

namespace App\Twig\Components;

use App\Entity\Recipe;
use App\Service\SendOrderService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(private SendOrderService $sendOrderService)
    {
    }

    #[LiveAction]
    public function sendOrderByMail(): void
    {
        if ($this->sendOrderService->sendOrder($this->recipe)) {
            $this->nbrSendOrder++;
        }
    }
}
