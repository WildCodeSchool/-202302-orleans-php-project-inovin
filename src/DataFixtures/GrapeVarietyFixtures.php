<?php

namespace App\DataFixtures;

use App\Entity\GrapeVariety;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GrapeVarietyFixtures extends Fixture
{
    public const GRAPE_VARIETIES = [
        'Gewurztraminer',
        'Riesling',
        'Pinot gris',
        'Muscat',
        'Sylvaner',
        'Pinot blanc ou Auxerrois',
        'Pinot noir',
        'Cabernet sauvignon',
        'Merlot',
        'Cabernet franc ',
        'Petit verdot',
        'Malbec',
        'Sauvignon',
        'Sémillon',
        'Muscadelle',
        'Grenache noir',
        'Carignan',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::GRAPE_VARIETIES as $key => $grapeVarietyName) {
            $grapeVariety = new GrapeVariety();
            $grapeVariety->setName($grapeVarietyName);
            $manager->persist($grapeVariety);
            $this->addReference('grape_variety_' . $key, $grapeVariety);
        }
        $manager->flush();
    }
}
