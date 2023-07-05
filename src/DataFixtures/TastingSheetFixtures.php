<?php

namespace App\DataFixtures;

use App\Entity\TastingSheet;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TastingSheetFixtures extends Fixture implements DependentFixtureInterface
{
    public const TASTING_SHEET_COUNT = 8;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::TASTING_SHEET_COUNT; $i++) {
            $tastingSheet = new TastingSheet();
            $tastingSheet->setTaste($faker->numberBetween(0, 10));
            $tastingSheet->setSmell($faker->numberBetween(0, 10));
            $tastingSheet->setVisual($faker->numberBetween(0, 10));

            $tastingSheet->setDate($faker->dateTimeThisYear(new DateTime()));

            $this->addReference('tastingSheet_' . $i, $tastingSheet);

            $manager->persist($tastingSheet);
        }


        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            SessionFixtures::class,
        ];
    }
}
