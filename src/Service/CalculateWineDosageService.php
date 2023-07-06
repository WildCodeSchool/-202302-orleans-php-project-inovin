<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Entity\TastingSheet;
use App\Repository\TastingSheetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;

#[IsGranted('ROLE_USER')]
class CalculateWineDosageService
{
    public function __construct(private TastingSheetRepository $tastingShRepository)
    {
    }
    public function calculate(Recipe $recipe): Recipe
    {
        $orderedItems = $this->orderedElementsByAverage($recipe);

        foreach ($orderedItems as $key => $itemOrdered) {
            foreach ($recipe->getTastingSheet() as $itemTastingSheet) {
                if ($itemOrdered['tastingSheet'] === $itemTastingSheet->getId()) {
                    switch ($key) {
                        case 0:
                            //$itemTastingSheet->setDosage(150);
                            $this->tastingShRepository->save($itemOrdered, true);
                            break;
                    }
                }
            }
        }

        return $recipe;
    }
    private function orderedElementsByAverage(Recipe $recipe): array
    {
        $result = [];
        foreach ($recipe->getTastingSheet() as $itemTastingSheet) {
            $result[] = [
                'tastingSheet' => $itemTastingSheet->getId(),
                'average' => $this->getAverage($itemTastingSheet)
            ];
        }

        $col = array_column($result, "average");

        array_multisort($col, SORT_ASC, $result);

        return $result;
    }
    private function getAverage(TastingSheet $tastingSheet): float
    {
        return (($tastingSheet->getSmell() ?? 0) +
            ($tastingSheet->getTaste() ?? 0) +
            ($tastingSheet->getVisual() ?? 0)) / 3;
    }
}
