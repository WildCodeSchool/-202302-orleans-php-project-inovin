<?php

namespace App\Entity;

use App\Repository\GrapeVarietyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: GrapeVarietyRepository::class)]
#[UniqueEntity('name')]
class GrapeVariety
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'grapeVarieties')]
    private ?GrapeColor $color = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): ?GrapeColor
    {
        return $this->color;
    }

    public function setColor(?GrapeColor $color): static
    {
        $this->color = $color;

        return $this;
    }
}
