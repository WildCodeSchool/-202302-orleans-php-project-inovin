<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Entity\TastingSheet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;

#[IsGranted('ROLE_USER')]
class CalculateWineDosageService
{
    public function calculate(Recipe $recipe): array
    {
        $result = [];

        foreach ($recipe->getTastingSheet() as $itemTastingSheet) {
            $result[] = [
                'tastingSheet' => $itemTastingSheet->getId(),
                'wine' => $itemTastingSheet->getWine()->getId(),
                'average' => $this->getAverage($itemTastingSheet)
            ];
        }

        return $result;
    }

    private function getAverage(TastingSheet $tastingSheet): float
    {
        return (($tastingSheet->getSmell() ?? 0) +
            ($tastingSheet->getTaste() ?? 0) +
            ($tastingSheet->getVisual() ?? 0)) / 3;
    }
}
