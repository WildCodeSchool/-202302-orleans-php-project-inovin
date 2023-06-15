<?php

namespace App\DataFixtures;

use App\DataFixtures\GrapeColorFixtures;
use App\Entity\GrapeVariety;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GrapeVarietyFixtures extends Fixture implements DependentFixtureInterface
{
    public const GRAPE_VARIETIES = [
        ['cepage' => 'Gewurztraminer', 'color' => 'blanc'],
        ['cepage' => 'Riesling', 'color' => 'blanc'],
        ['cepage' => 'Pinot gris', 'color' => 'gris'],
        ['cepage' => 'Muscat', 'color' => 'blanc'],
        ['cepage' => 'Sylvaner', 'color' => 'blanc'],
        ['cepage' => 'Pinot blanc ou Auxerrois', 'color' => 'blanc'],
        ['cepage' => 'Pinot noir', 'color' => 'rouge'],
        ['cepage' => 'Cabernet sauvignon', 'color' => 'rouge'],
        ['cepage' => 'Merlot', 'color' => 'rouge'],
        ['cepage' => 'Cabernet franc', 'color' => 'rouge'],
        ['cepage' => 'Petit verdot', 'color' => 'rouge'],
        ['cepage' => 'Malbec', 'color' => 'rouge'],
        ['cepage' => 'Sauvignon', 'color' => 'blanc'],
        ['cepage' => 'Sémillon', 'color' => 'blanc'],
        ['cepage' => 'Muscadelle', 'color' => 'blanc'],
        ['cepage' => 'Grenache noir', 'color' => 'rouge'],
        ['cepage' => 'Carignan', 'color' => 'rouge'],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (self::GRAPE_VARIETIES as $key => $grapeVarietyName) {
            $grapeVariety = new GrapeVariety();
            $grapeVariety->setName($grapeVarietyName['cepage']);
            $grapeColor = $this->getReference('grape_color_' . strtolower($grapeVarietyName['color']));
            $grapeVariety->setColor($grapeColor);
            $grapeVariety->setDescriptif($faker->paragraph());
            $manager->persist($grapeVariety);
            $this->addReference('grape_variety_' . $key, $grapeVariety);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GrapeColorFixtures::class,
        ];
    }
}
