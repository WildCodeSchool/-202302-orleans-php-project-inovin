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
        $recipeRepository = static::getContainer()->get(RecipeRepository::class);
        $recipe = $recipeRepository->find(2);
        $result = $calculateWineDosageService->calculate($recipe);
        //dd($result);

        $this->assertSame([
            [
                "tastingSheet_id" => 2,
                "average" => 7.33,
                "tasteRating" => 4.0,
                "smellRating" => 10.0,
                "visualRating" => 8.0,
                "dosage" => 150,
            ],
            [
                "tastingSheet_id" => 4,
                "average" => 4.67,
                "tasteRating" => 1.0,
                "smellRating" => 5.0,
                "visualRating" => 8.0,
                "dosage" => 50,
            ],
            [
                "tastingSheet_id" => 5,
                "average" => 4.0,
                "tasteRating" => 6.0,
                "smellRating" => 6.0,
                "visualRating" => 0.0,
                "dosage" => 25,
            ],
            [
                "tastingSheet_id" => 3,
                "average" => 2.67,
                "tasteRating" => 4.0,
                "smellRating" => 2.0,
                "visualRating" => 2.0,
                "dosage" => 0,
            ]
        ], $result);
    }
}
