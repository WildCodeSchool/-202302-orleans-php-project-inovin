<?php

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends Fixture
{
    public const REGIONS = [
        'Auvergne-Rhône-Alpes',
        'Bourgogne-Franche-Comté',
        'Bretagne',
        'Centre-Val de Loire',
        'Corse',
        'Grand Est',
        'Hauts-de-France',
        'Ile-de-France',
        'Normandie',
        'Nouvelle-Aquitaine',
        'Occitanie',
        'Pays de la Loire',
        'Provence Alpes Côte d\'Azur'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::REGIONS as $key => $value) {
            $region = new Region();
            $region->setName($value);
            $manager->persist($region);
            $this->addReference('region_' . $key, $region);
        }
        $manager->flush();
    }
}
