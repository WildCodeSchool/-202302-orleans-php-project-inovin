<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    public const RECIPE_COUNT = 2;
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::RECIPE_COUNT; $i++) {
            $faker = Factory::create('fr_FR');
            $recipe = new Recipe();
            $recipe->setName($faker->name());
            $recipe->setSessionRate($faker->randomNumber(1));
            $recipe->setSession($this->getReference('session_' . $i));
            $recipe->setUser($this->getReference('user_0'));
            $manager->persist($recipe);
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
