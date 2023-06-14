<?php

namespace App\DataFixtures;

use App\Entity\GrapeColor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GrapeColorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $grapeColorRouge = new GrapeColor();
        $grapeColorRouge->setColor('Rouge');
        $manager->persist($grapeColorRouge);
        $this->addReference('grape_color_rouge', $grapeColorRouge);

        $grapeColorBlanc = new GrapeColor();
        $grapeColorBlanc->setColor('Blanc');
        $manager->persist($grapeColorBlanc);
        $this->addReference('grape_color_blanc', $grapeColorBlanc);

        $grapeColorGris = new GrapeColor();
        $grapeColorGris->setColor('Gris');
        $manager->persist($grapeColorGris);
        $this->addReference('grape_color_gris', $grapeColorGris);

        $grapeColorRose = new GrapeColor();
        $grapeColorRose->setColor('Rosé');
        $manager->persist($grapeColorRose);
        $this->addReference('grape_color_rose', $grapeColorRose);

        $manager->flush();
    }
}
