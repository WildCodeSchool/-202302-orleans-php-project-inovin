<?php

namespace App\Entity;

use App\Repository\UserPreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPreferenceRepository::class)]
class UserPreference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $wineKnowledge = null;

    #[ORM\OneToOne(inversedBy: 'userPreference', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne]
    private ?GrapeColor $grapeColor = null;

    #[ORM\ManyToOne]
    private ?Region $region = null;

    #[ORM\ManyToOne]
    private ?WineTaste $wineTaste = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWineKnowledge(): ?string
    {
        return $this->wineKnowledge;
    }

    public function setWineKnowledge(?string $wineKnowledge): static
    {
        $this->wineKnowledge = $wineKnowledge;

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

    public function getGrapeColor(): ?GrapeColor
    {
        return $this->grapeColor;
    }

    public function setGrapeColor(?GrapeColor $grapeColor): static
    {
        $this->grapeColor = $grapeColor;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getWineTaste(): ?WineTaste
    {
        return $this->wineTaste;
    }

    public function setWineTaste(?WineTaste $wineTaste): static
    {
        $this->wineTaste = $wineTaste;

        return $this;
    }
}
