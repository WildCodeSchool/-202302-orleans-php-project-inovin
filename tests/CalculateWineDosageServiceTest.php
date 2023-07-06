<?php

namespace App\Tests;

use App\Entity\Recipe;
use App\Entity\TastingSheet;
use App\Repository\RecipeRepository;
use App\Service\CalculateWineDosageService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculateWineDosageServiceTest extends KernelTestCase
{
    public function testCalculedDosage(): void
    {
        $kernel = self::bootKernel();
        $calculateWineDosageService = static::getContainer()->get(CalculateWineDosageService::class);

        $recipe = new Recipe();
        $tastingSheet1 = new tastingSheet();
        $tastingSheet1->setDosage(0);
        $tastingSheet1->setTaste(4.0);
        $tastingSheet1->setSmell(2.0);
        $tastingSheet1->setVisual(2.0);
        $recipe->addTastingSheet($tastingSheet1);

        $tastingSheet2 = new tastingSheet();
        $tastingSheet2->setDosage(0);
        $tastingSheet2->setTaste(4.0);
        $tastingSheet2->setSmell(10.0);
        $tastingSheet2->setVisual(8.0);
        $recipe->addTastingSheet($tastingSheet2);

        $tastingSheet3 = new tastingSheet();
        $tastingSheet3->setDosage(0);
        $tastingSheet3->setTaste(6.0);
        $tastingSheet3->setSmell(6.0);
        $tastingSheet3->setVisual(0.0);
        $recipe->addTastingSheet($tastingSheet3);

        $tastingSheet4 = new tastingSheet();
        $tastingSheet4->setDosage(0);
        $tastingSheet4->setTaste(1.0);
        $tastingSheet4->setSmell(5.0);
        $tastingSheet4->setVisual(8.0);
        $recipe->addTastingSheet($tastingSheet4);

        $result = $calculateWineDosageService->calculate($recipe);

        $this->assertSame([
            [
                "tastingSheet_id" => null,
                "average" => 7.3,
                "tasteRating" => 4.0,
                "smellRating" => 10.0,
                "visualRating" => 8.0,
                "dosage" => 150,
            ],
            [
                "tastingSheet_id" => null,
                "average" => 4.7,
                "tasteRating" => 1.0,
                "smellRating" => 5.0,
                "visualRating" => 8.0,
                "dosage" => 50,
            ],
            [
                "tastingSheet_id" => null,
                "average" => 4.0,
                "tasteRating" => 6.0,
                "smellRating" => 6.0,
                "visualRating" => 0.0,
                "dosage" => 25,
            ],
            [
                "tastingSheet_id" => null,
                "average" => 2.7,
                "tasteRating" => 4.0,
                "smellRating" => 2.0,
                "visualRating" => 2.0,
                "dosage" => 0,
            ]
        ], $result);
    }
}
