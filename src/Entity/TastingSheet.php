<?php

namespace App\Entity;

use App\Repository\TastingSheetRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\NotBlank]
    #[Assert\Range(min: 0, max: 10)]
    private ?float $taste = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Range(min: 0, max: 10)]
    private ?float $smell = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Range(min: 0, max: 10)]
    private ?float $visual = null;

    #[ORM\ManyToOne(inversedBy: 'tastingSheet', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Recipe $recipe = null;

    #[ORM\ManyToOne(inversedBy: 'tastingSheets', fetch: 'EAGER')]
    private ?Wine $wine = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 0, max: 250)]
    private ?int $dosage = null;

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
        $this->setDate(new DateTime('now'));

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

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getWine(): ?Wine
    {
        return $this->wine;
    }

    public function setWine(?Wine $wine): static
    {
        $this->wine = $wine;

        return $this;
    }

    public function getDosage(): ?int
    {
        return $this->dosage;
    }

    public function setDosage(?int $dosage): static
    {
        $this->dosage = $dosage;

        return $this;
    }
}
