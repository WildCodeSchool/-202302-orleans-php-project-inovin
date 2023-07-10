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
    public const TASTING_SHEET_COUNT = 24;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $dosages = [0, 25, 50, 150];

        for ($i = 0; $i <= self::TASTING_SHEET_COUNT; $i++) {
            $tastingSheet = new TastingSheet();
            $wine = new WineFixtures();

            $dosage = $faker->randomElement($dosages);
            $key = array_Keys($dosages, $dosage)[0];
            unset($dosages[$key]);
            if (empty($dosages)) {
                $dosages = [0, 25, 50, 150];
            }
            /*  var_dump($i, $dosage, $dosages); */
            $tastingSheet->setTaste($faker->numberBetween(0, 10));
            $tastingSheet->setSmell($faker->numberBetween(0, 10));
            $tastingSheet->setVisual($faker->numberBetween(0, 10));
            $tastingSheet->setDosage($dosage);
            $tastingSheet->setWine($this->getReference('wine_' . $faker->numberBetween(1, $wine::WINE_COUNT - 1)));
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
            WineFixtures::class,
        ];
    }
}
