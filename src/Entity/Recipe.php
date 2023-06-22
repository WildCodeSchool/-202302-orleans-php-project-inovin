<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: TastingSheet::class)]
    private Collection $tastingSheet;

    public function __construct()
    {
        $this->tastingSheet = new ArrayCollection();
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
}
