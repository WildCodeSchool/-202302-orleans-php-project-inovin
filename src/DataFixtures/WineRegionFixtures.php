<?php

namespace App\DataFixtures;

use App\Entity\WineRegion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WineRegionFixtures extends Fixture
{
    public const WINE_REGIONS = [
        'Alsace',
        'Beaujolais',
        'Bordeaux',
        'Champagne',
        'Jura',
        'Languedoc-Roussillon',
        'Provence',
        'Savoie',
        'Sud-Ouest',
        'Vallée de la Loire',
        'Vallée du Rhône'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::WINE_REGIONS as $key => $value) {
            $wineRegion = new WineRegion();
            $wineRegion->setRegionName($value);
            $manager->persist($wineRegion);
            $this->addReference('wineRegion_' . $key, $wineRegion);
        }
        $manager->flush();
    }
}
