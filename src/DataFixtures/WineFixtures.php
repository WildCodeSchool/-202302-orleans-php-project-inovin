<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Wine;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class WineFixtures extends Fixture
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

            $wine->setGrapVariety($this->getReference('grape_variety_' . $faker->numberBetween(1, 16)));

            $this->addReference('wine_' . $i, $wine);

            $manager->persist($wine);
        }


        $manager->flush();
    }
}
