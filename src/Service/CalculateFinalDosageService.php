<?php

namespace App\Service;

use App\Entity\Recipe;

class CalculateFinalDosageService
{
    public function calculate(Recipe $recipe): int
    {
        $result = 0;
        $tastingSheet = $recipe->getTastingSheet();

        foreach ($tastingSheet as $itemTastingSheet) {
            $dosage = $itemTastingSheet->getDosage();
            $result += $dosage;
        }

        return $result;
    }
}
