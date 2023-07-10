<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\Entity\UserPreference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserPreferenceFixtures extends Fixture implements DependentFixtureInterface
{
    public const KNOWLEDGES = ['Amateur', 'Connaisseur', 'Oenologue'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < UserFixtures::MEMBERS; $i++) {
            $member = $this->getReference('member_' . $i);
            $userPref = new UserPreference();
            $userPref->setUser($member);

            $grapeColor = $this->getReference('grape_color_' .
                $faker->randomElement(['rouge', 'blanc', 'gris', 'rose']));
            $userPref->setGrapeColor($grapeColor);

            $region = $this->getReference('region_' .
                $faker->numberBetween(0, count(RegionFixtures::REGIONS) - 1));
            $userPref->setRegion($region);

            $wineTaste = $this->getReference('winetaste_' .
                $faker->numberBetween(0, count(WineTasteFixtures::WINE_TASTES) - 1));
            $userPref->setWineTaste($wineTaste);

            $userPref->setWineKnowledge($faker->randomElement(self::KNOWLEDGES));

            $manager->persist($userPref);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            GrapeColorFixtures::class,
            RegionFixtures::class,
            WineTasteFixtures::class,
        ];
    }
}
