<?php

namespace App\Twig\Components;

use App\Entity\Wine;
use App\Repository\WineRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[IsGranted('ROLE_ADMIN')]
#[AsLiveComponent()]
class EnableDesableWineComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: ['isEnabled'])]
    public ?Wine $wine = null;

    public function __construct(private WineRepository $wineRepository)
    {
    }

    #[LiveAction]
    public function updateState(): void
    {
        $this->wineRepository->save($this->wine, true);
    }
}
