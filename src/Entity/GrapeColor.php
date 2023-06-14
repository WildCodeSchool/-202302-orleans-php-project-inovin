<?php

namespace App\Entity;

use App\Repository\GrapeColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('color')]
#[ORM\Entity(repositoryClass: GrapeColorRepository::class)]
class GrapeColor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\OneToMany(mappedBy: 'color', targetEntity: GrapeVariety::class)]
    private Collection $grapeVarieties;

    public function __construct()
    {
        $this->grapeVarieties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, GrapeVariety>
     */
    public function getGrapeVarieties(): Collection
    {
        return $this->grapeVarieties;
    }

    public function addGrapeVariety(GrapeVariety $grapeVariety): static
    {
        if (!$this->grapeVarieties->contains($grapeVariety)) {
            $this->grapeVarieties->add($grapeVariety);
            $grapeVariety->setColor($this);
        }

        return $this;
    }

    public function removeGrapeVariety(GrapeVariety $grapeVariety): static
    {
        if ($this->grapeVarieties->removeElement($grapeVariety)) {
            // set the owning side to null (unless already changed)
            if ($grapeVariety->getColor() === $this) {
                $grapeVariety->setColor(null);
            }
        }

        return $this;
    }
}
