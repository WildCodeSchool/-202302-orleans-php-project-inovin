<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
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
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::WINE_COUNT; $i++) {
            $wine = new Wine();
            $wine->setName($faker->word);

            $wine->setYear((int)$faker->year());

            $wine->setVolume($faker->randomFloat(2, 1.0, 2.0));

            $wine->setAlcoholPercent($faker->randomFloat(2, 10, 16));

            $wine->setPrice($faker->randomFloat(2, 5, 50));

            $wine->setIsEnabled($faker->boolean());

            $wine->setOrigin($faker->country());

            $wine->setProtectedOrigin($faker->randomElement(['AOC', 'AOP', 'IGP']));

            $wine->setGrapeVariety($this->getReference('grape_variety_' . $faker->numberBetween(1, 16)));

            if ($i % 2 === 0) {
                $simpleUser1 = $this->getReference('user_0');
                $wine->addLikedUser($simpleUser1);
            }

            $this->addReference('wine_' . $i, $wine);

            $manager->persist($wine);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GrapeVarietyFixtures::class,
            UserFixtures::class,
        ];
    }
}
