<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\DataFixtures\WineRegionFixtures;
use App\DataFixtures\WineTasteFixtures;
use App\Entity\UserPreference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserPreferenceFixtures extends Fixture implements DependentFixtureInterface
{
    protected array $wineKnowledge = [
        'Un amateur de vin désireux de découvrir et d’apprendre' => 'Amateur',
        'Un bon connaisseur pour qui le vin n’a pas de secrets' => 'Connaisseur',
        'Un véritable oenologue' => 'Oenologue',
    ];

    protected array $wineColour = [
        'Le vin rouge' => 'Le vin rouge',
        'Le vin blanc' => 'Le vin blanc',
        'Le vin rosé' => 'Le vin rosé',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= UserFixtures::MEMBERS; $i++) {
            $quiz = new UserPreference();
            $quiz->setUser($this->getReference('user_' . ($i + 3)));
            $quiz->setWineColour($faker->randomElement($this->wineColour));
            $quiz->setWineKnowledge($faker->randomElement($this->wineKnowledge));
            $quiz->setWineRegion($this->getReference('wineRegion_' .
                $faker->numberBetween(0, (count(WineRegionFixtures::WINE_REGIONS) - 1))));
            $quiz->setWineTaste($this->getReference('wineTaste_' .
                $faker->numberBetween(0, (count(WineTasteFixtures::WINE_TASTES) - 1))));

            $this->addReference('userPreference_' . $i, $quiz);

            $manager->persist($quiz);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            WineTasteFixtures::class,
            WineRegionFixtures::class,
        ];
    }
}
