<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Entity\TastingSheet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;

#[IsGranted('ROLE_USER')]
class CalculateWineDosageService
{
    /**
     * en entrée : l'objet recette
     * en retour : un tableau ordonné par 'avergae'
     * puis 'tasteRating'
     * puis 'smellRating'
     * puis 'visualRating'
     * sous la forme suivante :
     *  [
     *    [
     *      tastingSheet_id' => 22,
     *      dosage'=> 150,
     *      average' => 5.3 ,
     *      tasteRating' => 8,
     *      smellRating' => 5,
     *      visualRating' => 3
     *    ],
     *    [
     *      'tastingSheet_id' => 10,
     *      'dosage'=> 50,
     *      'average' => 5.3 ,
     *      'tasteRating' => 8,
     *      'smellRating' => 4,
     *      'visualRating' => 4
     *    ],
     *    [
     *      'tastingSheet_id' => 50,
     *      'dosage'=> 25,
     *      'average' => 4.3 ,
     *      'tasteRating' => 8,
     *      'smellRating' => 3,
     *      'visualRating' => 2
     *    ],
     *    [
     *      'tastingSheet_id' => 51,
     *      'dosage'=> 0,
     *      'average' => 2.6 ,
     *      'tasteRating' => 4,
     *      'smellRating' => 3,
     *      'visualRating' => 1
     *    ],
     *  ]
     */
    public function calculate(Recipe $recipe): array
    {
        $result = [];
        foreach ($recipe->getTastingSheet() as $itemTastingSheet) {
            $result[] = [
                'tastingSheet_id' => $itemTastingSheet->getId(),
                'average' => 0,
                'tasteRating' => $itemTastingSheet->getTaste(),
                'smellRating' => $itemTastingSheet->getSmell(),
                'visualRating' => $itemTastingSheet->getVisual(),
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
        //order items array by column average value.
        $colAverage = array_column($array, "average");
        $colTasting = array_column($array, "tasteRating");
        $colSmell = array_column($array, "smellRating");
        $colVisual = array_column($array, "visualRating");

        array_multisort(
            $colAverage,
            SORT_DESC,
            $colTasting,
            SORT_DESC,
            $colSmell,
            SORT_DESC,
            $colVisual,
            SORT_DESC,
            $array
        );

        return $array;
    }

    private function setAverage(array $item): float
    {
        return round((($item['tasteRating'] ?? 0) +
            ($item['smellRating'] ?? 0) +
            ($item['visualRating'] ?? 0)) / 3, 1);
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
        foreach (array_keys($ordonedArray) as $key) {
            switch ($key) {
                case 0:
                    $ordonedArray[$key]['dosage'] = 150;
                    break;
                case 1:
                    $ordonedArray[$key]['dosage'] = 50;
                    break;
                case 2:
                    $ordonedArray[$key]['dosage'] = 25;
                    break;
                default:
                    break;
            }
        }
        return $ordonedArray;
    }
}
