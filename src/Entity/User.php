<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il existe déjà un compte avec cette adresse e-mail.')]
/** @SuppressWarnings(PHPMD.ExcessiveClassComplexity) */
class User implements
    UserInterface,
    PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 150)]
    private ?string $firstname = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 150)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThanOrEqual('+18 years')]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $dateBirth = null;

    #[ORM\Column(length: 9)]
    #[Assert\Length(max: 9)]
    #[Assert\Regex(pattern: '/^\d+$/')]
    #[Assert\NotBlank]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank]
    private ?string $country = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Recipe::class)]
    private Collection $recipes;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserPreference $userPreference = null;

    #[ORM\ManyToMany(targetEntity: Wine::class, inversedBy: 'likedUsers')]
    #[ORM\JoinTable(name: 'favorite_wine')]
    private Collection $favoritesWines;

    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'likedUsers')]
    private Collection $favoritesRecipes;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[ORM\Column]
    private ?bool $quizAnswered = false;

    public function __construct(?bool $enabled = true)
    {
        $this->enabled = $enabled;
        $this->recipes = new ArrayCollection();
        $this->favoritesWines = new ArrayCollection();
        $this->favoritesRecipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateBirth(): ?DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(?DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

            return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): static
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setUser($this);
        }
        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getUser() === $this) {
                $recipe->setUser(null);
            }
        }
        return $this;
    }

    public function getUserPreference(): ?UserPreference
    {
        return $this->userPreference;
    }

    public function setUserPreference(?UserPreference $userPreference): static
    {
        if ($userPreference === null && $this->userPreference !== null) {
            $this->userPreference->setUser(null);
        }
        if ($userPreference !== null && $userPreference->getUser() !== $this) {
            $userPreference->setUser($this);
        }
        $this->userPreference = $userPreference;
        return $this;
    }

    /**
     * @return Collection<int, Wine>
     */
    public function getFavoritesWines(): Collection
    {
        return $this->favoritesWines;
    }

    public function addFavoritesWine(Wine $favoritesWine): static
    {
        if (!$this->favoritesWines->contains($favoritesWine)) {
            $this->favoritesWines->add($favoritesWine);
            $favoritesWine->addLikedUser($this);
        }
        return $this;
    }

    public function removeFavoritesWine(Wine $favoritesWine): static
    {
        if ($this->favoritesWines->removeElement($favoritesWine)) {
            $favoritesWine->removeLikedUser($this);
        }
        return $this;
    }

    public function isInFavoritesWines(Wine $wine): bool
    {
        return $this->favoritesWines->contains($wine);
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getFavoritesRecipes(): Collection
    {
        return $this->favoritesRecipes;
    }

    public function addFavoritesRecipe(Recipe $favoritesRecipe): static
    {
        if (!$this->favoritesRecipes->contains($favoritesRecipe)) {
            $this->favoritesRecipes->add($favoritesRecipe);
            $favoritesRecipe->addLikedUser($this);
        }

        return $this;
    }

    public function removeFavoritesRecipe(Recipe $favoritesRecipe): static
    {
        if ($this->favoritesRecipes->removeElement($favoritesRecipe)) {
            $favoritesRecipe->removeLikedUser($this);
        }

        return $this;
    }

    public function isInFavoritesRecipes(Recipe $recipe): bool
    {
        return $this->favoritesRecipes->contains($recipe);
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isQuizAnswered(): ?bool
    {
        return $this->quizAnswered;
    }

    public function setQuizAnswered(bool $quizAnswered): static
    {
        $this->quizAnswered = $quizAnswered;

        return $this;
    }
}
