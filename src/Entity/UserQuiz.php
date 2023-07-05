<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserQuizRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: UserQuizRepository::class)]
class UserQuiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $questionText = null;

    #[ORM\Column]
    private array $options = [];

    #[ORM\OneToOne(mappedBy: 'preferences', cascade: ['persist', 'remove'])]
    private ?User $userPreferences = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): static
    {
        $this->questionText = $questionText;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function getUserPreferences(): ?User
    {
        return $this->userPreferences;
    }

    public function setUserPreferences(?User $userPreferences, array $preferences): static
    {
        // set the owning side of the relation if necessary
        if ($userPreferences->getPreferences() !== $this) {
            $userPreferences->setPreferences($preferences);
        }

        $this->userPreferences = $userPreferences;

        return $this;
    }
}
