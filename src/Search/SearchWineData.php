<?php

namespace App\Search;

use App\Entity\GrapeVariety;

class SearchWineData
{
    private ?string $name = '';
    private array $grapeVarieties = [];
    private ?int $maxPrice = null;
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
