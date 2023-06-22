<?php

namespace App\Entity;

use App\Repository\TastingSheetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TastingSheetRepository::class)]
class TastingSheet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $taste = null;

    #[ORM\Column]
    private ?float $smell = null;

    #[ORM\Column]
    private ?float $visual = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTaste(): ?float
    {
        return $this->taste;
    }

    public function setTaste(float $taste): static
    {
        $this->taste = $taste;

        return $this;
    }

    public function getSmell(): ?float
    {
        return $this->smell;
    }

    public function setSmell(float $smell): static
    {
        $this->smell = $smell;

        return $this;
    }

    public function getVisual(): ?float
    {
        return $this->visual;
    }

    public function setVisual(float $visual): static
    {
        $this->visual = $visual;

        return $this;
    }
}
