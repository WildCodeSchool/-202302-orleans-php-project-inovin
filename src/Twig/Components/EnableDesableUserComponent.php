<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent()]
class EnableDesableUserComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: ['enabled'])]
    public ?User $user = null;

    public function __construct(private UserRepository $userRepository)
    {
    }

    #[LiveAction]
    public function updateUser(): void
    {
        $this->userRepository->save($this->user, true);
    }
}
