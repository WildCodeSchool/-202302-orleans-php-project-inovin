<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Entity\Wine;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Bundle\SecurityBundle\Security;

#[IsGranted('ROLE_USER')]
#[AsLiveComponent()]

class UpdateStateFavoriteWineComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public bool $isFavorite = false;

    #[LiveProp]
    public ?Wine $wine = null;

    public function __construct(private Security $security, private UserRepository $userRepository)
    {
    }

    #[LiveAction]
    public function updateState(): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $this->isFavorite = false;

        if (!$user->isInFavoriteWines($this->wine)) {
            $user->addFavoriteWines($this->wine);
            $this->isFavorite = true;
        } else {
            $user->removeFavoriteWines($this->wine);
        }
        $this->userRepository->save($user, true);
    }

    public function getState(): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $this->isFavorite =  $user->isInFavoriteWines($this->wine);
    }
}
