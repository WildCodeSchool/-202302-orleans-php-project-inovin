<?php

namespace App\Entity;

use App\Repository\WineTasteRepository;
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
}
