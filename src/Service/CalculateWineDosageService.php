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
     *      average' => 5.33 ,
     *      tasteRating' => 8,
     *      smellRating' => 5,
     *      visualRating' => 3
     *    ],
     *    [
     *      'tastingSheet_id' => 10,
     *      'dosage'=> 50,
     *      'average' => 5.33 ,
     *      'tasteRating' => 8,
     *      'smellRating' => 4,
     *      'visualRating' => 4
     *    ],
     *    [
     *      'tastingSheet_id' => 50,
     *      'dosage'=> 25,
     *      'average' => 4.33 ,
     *      'tasteRating' => 8,
     *      'smellRating' => 3,
     *      'visualRating' => 2
     *    ],
     *    [
     *      'tastingSheet_id' => 51,
     *      'dosage'=> 0,
     *      'average' => 2.66 ,
     *      'tasteRating' => 4,
     *      'smellRating' => 3,
     *      'visualRating' => 1
     *    ],
     *  ]
     */
    public function calculate(Recipe $recipe): array
    {
        //add averages values
        $array = $this->calculateAverageValues($recipe);

        //ordered array
        $orderedArray = $this->orderedElementsByAverage($array);

        //set Dosage based on the ordered items array
        return $this->setDosage($orderedArray);
    }

    /**
     * Calculate the average for each TastingSheet based on
     * the 3 values taste, smell and visual.
     */
    private function calculateAverageValues(Recipe $recipe): array
    {
        $result = [];
        //create the array result (not ordered yet)
        foreach ($recipe->getTastingSheet() as $itemTastingSheet) {
            $result[] = [
                'tastingSheet_id' => $itemTastingSheet->getId(),
                'average' => $this->setAverage($itemTastingSheet),
                'tasteRating' => $itemTastingSheet->getTaste(),
                'smellRating' => $itemTastingSheet->getSmell(),
                'visualRating' => $itemTastingSheet->getVisual(),
                'dosage' => 0
            ];
        }
        return $result;
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

    private function setAverage(TastingSheet $tastingSheet): float
    {
        return round((($tastingSheet->getSmell() ?? 0) +
            ($tastingSheet->getTaste() ?? 0) +
            ($tastingSheet->getVisual() ?? 0)) / 3, 2);
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
