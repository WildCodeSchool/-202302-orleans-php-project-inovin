<?php

namespace App\Entity;

use App\Repository\WineTasteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WineTasteRepository::class)]
class WineTaste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tasteName = null;

    #[ORM\OneToMany(mappedBy: 'wineTaste', targetEntity: Wine::class)]
    private Collection $wines;

    public function __construct()
    {
        $this->wines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTasteName(): ?string
    {
        return $this->tasteName;
    }

    public function setTasteName(string $tasteName): static
    {
        $this->tasteName = $tasteName;

        return $this;
    }

    /**
     * @return Collection<int, Wine>
     */
    public function getWines(): Collection
    {
        return $this->wines;
    }

    public function addWine(Wine $wine): static
    {
        if (!$this->wines->contains($wine)) {
            $this->wines->add($wine);
            $wine->setWineTaste($this);
        }

        return $this;
    }

    public function removeWine(Wine $wine): static
    {
        if ($this->wines->removeElement($wine)) {
            // set the owning side to null (unless already changed)
            if ($wine->getWineTaste() === $this) {
                $wine->setWineTaste(null);
            }
        }

        return $this;
    }
}
