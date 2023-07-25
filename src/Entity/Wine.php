<?php

namespace App\Entity;

use App\Repository\WineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use phpDocumentor\Reflection\Types\Float_;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WineRepository::class)]
#[Vich\Uploadable]
class Wine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column()]
    #[Assert\NotBlank]
    #[Assert\Range(min: 1900, max: 'now')]
    private ?int $year = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Positive()]
    private ?float $volume = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'wine_file', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize: '1M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
    )]
    private ?File $wineFile = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[ORM\ManyToOne(inversedBy: 'wines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GrapeVariety $grapeVariety = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 1)]
    #[Assert\NotBlank]
    #[Assert\Positive()]
    #[Assert\Range(
        min: 0,
        max: 100,
    )]
    #[Assert\Type(type: 'float')]
    private ?float $alcoholPercent = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Positive()]
    #[Assert\Type(type: 'float')]
    private ?float $price = null;

    #[ORM\ManyToMany(targetEntity: Session::class, mappedBy: 'wines')]
    private Collection $sessions;
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $origin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $protectedOrigin = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favoriteWines')]
    private Collection $favoriteUsers;

    #[ORM\OneToMany(mappedBy: 'wine', targetEntity: TastingSheet::class)]
    private Collection $tastingSheets;

    #[ORM\ManyToOne(inversedBy: 'wines')]
    private ?WineRegion $wineRegion = null;

    #[ORM\ManyToOne(inversedBy: 'wines')]
    private ?WineTaste $wineTaste = null;

    public function __construct(?bool $enabled = true)
    {
        $this->enabled = $enabled;
        $this->sessions = new ArrayCollection();
        $this->favoriteUsers = new ArrayCollection();
        $this->tastingSheets = new ArrayCollection();
    }

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

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(float $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setIsEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getGrapeVariety(): ?GrapeVariety
    {
        return $this->grapeVariety;
    }

    public function setGrapeVariety(?GrapeVariety $grapeVariety): self
    {
        $this->grapeVariety = $grapeVariety;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getAlcoholPercent(): ?float
    {
        return $this->alcoholPercent;
    }

    public function setAlcoholPercent(float $alcoholPercent): static
    {
        $this->alcoholPercent = $alcoholPercent;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->addWine($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            $session->removeWine($this);
        }
        return $this;
    }

    public function setWineFile(File $image = null): Wine
    {
        $this->wineFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getWineFile(): ?File
    {
        return $this->wineFile;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(DateTime $updatedAt): Wine
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getProtectedOrigin(): ?string
    {
        return $this->protectedOrigin;
    }

    public function setProtectedOrigin(?string $protectedOrigin): static
    {
        $this->protectedOrigin = $protectedOrigin;

        return $this;
    }

    public function getFullLabel(): string
    {
        return $this->getName() . ' - ' .  $this->getYear() .  ' - ' . $this->getGrapeVariety()->getName();
    }


    /**
     * @return Collection<int, TastingSheet>
     */
    public function getTastingSheets(): Collection
    {
        return $this->tastingSheets;
    }

    public function addTastingSheet(TastingSheet $tastingSheet): static
    {
        if (!$this->tastingSheets->contains($tastingSheet)) {
            $this->tastingSheets->add($tastingSheet);
            $tastingSheet->setWine($this);
        }

        return $this;
    }

    public function removeTastingSheet(TastingSheet $tastingSheet): static
    {
        if ($this->tastingSheets->removeElement($tastingSheet)) {
            // set the owning side to null (unless already changed)
            if ($tastingSheet->getWine() === $this) {
                $tastingSheet->setWine(null);
            }
        }

        return $this;
    }


    public function addFavoriteUsers(User $user): static
    {
        if (!$this->favoriteUsers->contains($user)) {
            $this->favoriteUsers->add($user);
            $user->addFavoriteWines($this);
        }
        return $this;
    }

    public function removeFavoriteUsers(User $user): static
    {
        if ($this->favoriteUsers->removeElement($user)) {
            $user->removeFavoriteWines($this);
        }
        return $this;
    }

    public function isInFavoriteUsers(User $user): bool
    {
        return $this->favoriteUsers->contains($user);
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavoriteUsers(): Collection
    {
        return $this->favoriteUsers;
    }

    public function getWineRegion(): ?WineRegion
    {
        return $this->wineRegion;
    }

    public function setWineRegion(?WineRegion $wineRegion): static
    {
        $this->wineRegion = $wineRegion;

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
