<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipes', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'recipes', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: TastingSheet::class, cascade: ['persist'], fetch: 'EAGER')]
    private Collection $tastingSheet;

    #[ORM\Column(length: 35)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 35)]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 10)]
    #[Assert\Type('integer')]
    private ?int $sessionRate = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favoriteRecipes')]
    #[JoinTable(name: 'favorite_recipe')]
    private Collection $favoriteUsers;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'likedRecipes')]
    private Collection $likedUsers;

    public function __construct()
    {
        $this->tastingSheet = new ArrayCollection();
        $this->favoriteUsers = new ArrayCollection();
        $this->likedUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, TastingSheet>
     */
    public function getTastingSheet(): Collection
    {
        return $this->tastingSheet;
    }

    public function addTastingSheet(TastingSheet $tastingSheet): static
    {
        if (!$this->tastingSheet->contains($tastingSheet)) {
            $this->tastingSheet->add($tastingSheet);
            $tastingSheet->setRecipe($this);
        }

        return $this;
    }

    public function removeTastingSheet(TastingSheet $tastingSheet): static
    {
        if ($this->tastingSheet->removeElement($tastingSheet)) {
            // set the owning side to null (unless already changed)
            if ($tastingSheet->getRecipe() === $this) {
                $tastingSheet->setRecipe(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSessionRate(): ?int
    {
        return $this->sessionRate;
    }

    public function setSessionRate(int $sessionRate): static
    {
        $this->sessionRate = $sessionRate;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoriteUsers(): Collection
    {
        return $this->favoriteUsers;
    }

    public function addFavoriteUsers(User $user): static
    {
        if (!$this->favoriteUsers->contains($user)) {
            $this->favoriteUsers->add($user);
            $user->addFavoriteRecipes($this);
        }

        return $this;
    }

    public function removeFavoriteUsers(User $user): static
    {
        if ($this->favoriteUsers->removeElement($user)) {
            $user->removeFavoriteRecipes($this);
        }

        return $this;
    }

    public function isInFavoriteUsers(User $user): bool
    {
        return $this->favoriteUsers->contains($user);
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikedUsers(): Collection
    {
        return $this->likedUsers;
    }

    public function addLikedUsers(User $likedUser): static
    {
        if (!$this->likedUsers->contains($likedUser)) {
            $this->likedUsers->add($likedUser);
        }

        return $this;
    }

    public function removeLikedUsers(User $likedUser): static
    {
        $this->likedUsers->removeElement($likedUser);

        return $this;
    }
}
