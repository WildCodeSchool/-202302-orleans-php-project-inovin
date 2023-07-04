<?php

namespace App\Search;

use App\Entity\GrapeVariety;
use Symfony\Component\Validator\Constraints as Assert;

class SearchWineData
{
    public const MIN_PRICE = 0;
    public const MAX_PRICE = 100;

    #[Assert\Length(max: 255)]
    private ?string $name = '';
    private array $grapeVarieties = [];

    #[Assert\PositiveOrZero]
    #[Assert\Range(
        min: self::MIN_PRICE,
        max: self::MAX_PRICE,
    )]
    private ?int $maxPrice = null;

    #[Assert\PositiveOrZero]
    private ?int $minPrice = null;

    /**
     * Get the value of name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of grapeVarieties
     *
     * @return  self
     */
    public function setGrapeVarieties(array $grapeVarieties)
    {
        $this->grapeVarieties = $grapeVarieties;

        return $this;
    }

    public function getGrapeVarieties(): array
    {
        return $this->grapeVarieties;
    }

    /**
     * Get the value of maxPrice
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * Get the value of minPrice
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    /**
     * Set the value of minPrice
     *
     * @return  self
     */
    public function setMinPrice(?int $minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    /**
     * Set the value of minPrice
     *
     * @return  self
     */
    public function setMaxPrice(?int $maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }
}
