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

            $wine->setVolume($faker->numberBetween(3, true));

            $wine->setAlcoholPercent($faker->randomFloat(1, 1, 90));

            $wine->setIsEnable($faker->boolean());

            $wine->setGrapVariety($this->getReference('grape_variety_' . $faker->numberBetween(1, 16)));

            $manager->persist($wine);

            $this->addReference('wine_' . $i, $wine);
        }


        $manager->flush();
    }
}
