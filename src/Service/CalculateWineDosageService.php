<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Entity\TastingSheet;

class CalculateWineDosageService
{
    public const DOSAGES = [150, 75, 25, 0];

    /**
     * en entrée : l'objet recette
     */
    public function calculate(Recipe $recipe): array
    {
        $result = [];
        foreach ($recipe->getTastingSheet() as $itemTastingSheet) {
            $result[] = [
                'tastingSheet' => $itemTastingSheet,
                'average' => 0,
                'dosage' => 0
            ];
        }
        //add averages values
        $resultWithAverage = $this->calculateAverageValues($result);

        //ordered array
        $orderedResult = $this->orderedElementsByAverage($resultWithAverage);

        //set Dosage based on the ordered items array
        return $this->setDosage($orderedResult);
    }

    /**
     * Calculate the average for each TastingSheet based on
     * the 3 values taste, smell and visual.
     */
    private function calculateAverageValues(array $arrayItems): array
    {
        //create the array result (not ordered yet)
        foreach ($arrayItems as $key => $item) {
            $arrayItems[$key]['average'] =  $this->setAverage($item);
        }
        return $arrayItems;
    }

    /**
     *  Order the array by the field Average and TasteRating and smellRating and visualRating
     *
     */
    private function orderedElementsByAverage(array $array): array
    {
        $averages = $tastings = $smells =  $visuals = [];

        $averages = array_column($array, "average");

        foreach ($array as $item) {
            $tastings[] = $item['tastingSheet']->getTaste();
            $smells[] = $item['tastingSheet']->getSmell();
            $visuals[] = $item['tastingSheet']->getVisual();
        }

        //order items array by column average value.
        array_multisort(
            $averages,
            SORT_DESC,
            $tastings,
            SORT_DESC,
            $smells,
            SORT_DESC,
            $visuals,
            SORT_DESC,
            $array
        );
        return $array;
    }

    private function setAverage(array $item): float
    {
        return round((($item['tastingSheet']->getTaste() ?? 0) +
            ($item['tastingSheet']->getSmell() ?? 0) +
            ($item['tastingSheet']->getVisual() ?? 0)) / 3, 1);
    }

    /**
     * Rules :
     * First => 150ml
     * second => 50ml
     * third => 25ml
     * other => 0
     */
    private function setDosage(array $ordonedArray): array
    {
        $result = [];

        foreach ($ordonedArray as $key => $value) {
            $result[] = [
                "tastingSheet" => $value['tastingSheet'],
                "average" => $value['average'],
                "dosage" => self::DOSAGES[$key] ?? 0,
            ];
        }

        return $result;
    }
}
