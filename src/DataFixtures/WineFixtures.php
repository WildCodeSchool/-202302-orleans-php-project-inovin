<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Wine;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\GrapeVarietyFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class WineFixtures extends Fixture implements DependentFixtureInterface
{
    public const WINE_COUNT = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::WINE_COUNT; $i++) {
            $wine = new Wine();
            $wine->setName($faker->word);

            $wine->setYear((int)$faker->year());

            $wine->setVolume($faker->randomFloat(1, 2, 2));

            $wine->setAlcoholPercent((string)$faker->randomFloat(1, 1, 90));

            $wine->setIsEnabled($faker->boolean());

            $wine->setGrapeVariety($this->getReference('grape_variety_' . $faker->numberBetween(1, 16)));

            $this->addReference('wine_' . $i, $wine);

            $manager->persist($wine);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GrapeVarietyFixtures::class,
        ];
    }
}
