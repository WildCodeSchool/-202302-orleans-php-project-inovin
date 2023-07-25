<?php

namespace App\Twig\Components;

use App\Entity\Recipe;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Bundle\SecurityBundle\Security;

#[AsLiveComponent()]
class UpdateStateLikeRecipeComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp]
    public bool $isLiked = false;

    #[LiveProp]
    public int $countVotes = 0;

    #[LiveProp]
    public ?Recipe $recipe = null;
    public function __construct(private Security $security, private UserRepository $userRepository)
    {
    }

    #[IsGranted('ROLE_USER')]
    #[LiveAction]
    public function updateState(): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        $this->isLiked = false;

        if (!$user->isInLikedRecipes($this->recipe)) {
            $user->addLikedRecipes($this->recipe);
            $this->isLiked = true;
        } else {
            $user->removeLikedRecipes($this->recipe);
        }
        $this->userRepository->save($user, true);
        $this->countVotes = $this->recipe->getLikedUsers()->count();
    }

    public function getState(): void
    {

        /** @var User $user */
        $user = $this->security->getUser();

        if ($user != null) {
            $this->isLiked =  $user->isInLikedRecipes($this->recipe);
        }
        $this->countVotes = $this->recipe->getLikedUsers()->count();
    }
}
