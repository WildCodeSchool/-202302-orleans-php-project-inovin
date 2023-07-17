<?php

namespace App\DataFixtures;

use App\Entity\WineTaste;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WineTasteFixtures extends Fixture
{
    public const WINE_TASTES = ['Sec', 'Demi-sec', 'Moelleux', 'Liquoreux', 'Pétillant', 'Tranquille'];
    public function load(ObjectManager $manager): void
    {
        foreach (self::WINE_TASTES as $key => $value) {
            $wineTaste = new WineTaste();
            $wineTaste->setTasteName($value);
            $manager->persist($wineTaste);
            $this->addReference('wineTaste_' . $key, $wineTaste);
        }
        $manager->flush();
    }
}
