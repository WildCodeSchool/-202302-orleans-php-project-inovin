<?php

namespace App\Twig\Components;

use App\Entity\Recipe;
use App\Entity\User;
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

class UpdateStateFavoriteRecipeComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public bool $isFavorite = false;

    #[LiveProp]
    public ?Recipe $recipe = null;

    public function __construct(private Security $security, private UserRepository $userRepository)
    {
    }

    #[LiveAction]
    public function updateState(): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $this->isFavorite = false;

        if (!$user->isInFavoriteRecipes($this->recipe)) {
            $user->addFavoriteRecipes($this->recipe);
            $this->isFavorite = true;
        } else {
            $user->removeFavoriteRecipes($this->recipe);
        }
        $this->userRepository->save($user, true);
    }

    public function getState(): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $this->isFavorite =  $user->isInFavoriteRecipes($this->recipe);
    }
}
