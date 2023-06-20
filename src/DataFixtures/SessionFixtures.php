<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use DateTimeInterface;
use App\Entity\Session;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SessionFixtures extends Fixture implements DependentFixtureInterface
{
    public const SESSIONS = [
        'Découverte des cépages : Explorez les variétés de vins du monde',
        'Vins et fromages : Une harmonie parfaite',
        'Un voyage au cœur des vignobles : Les terroirs qui donnent vie aux vins',
        'Dégustation à l\'aveugle : Développez vos sens et testez vos connaissances',
        'Vins effervescents : Champagne, Prosecco et bien plus encore',
        'Le monde du vin en une soirée : Une initiation complète',
        'Accords mets et vins : Trouvez l\'équilibre parfait',
        'Vins bio et naturels : Dégustez des vins respectueux de l\'environnement',
        'Vins rares et prestigieux : Une expérience d\'exception',
        'Découverte des vins du Nouveau Monde : Des saveurs exotiques à explorer',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (self::SESSIONS as $key => $sessionName) {
            $session = new Session();
            $wine = new WineFixtures();

            $session->setName($sessionName);
            $session->setOpeningDate($faker->dateTimeThisYear(new DateTime()));
            $session->setDescription($faker->sentence(200));
            $session->setClosed($faker->boolean());

            $wine1 = $this->getReference('wine_' . $faker->numberBetween(1, $wine::WINE_COUNT - 1));
            $wine2 = $this->getReference('wine_' . $faker->numberBetween(1, $wine::WINE_COUNT - 1));
            $wine3 = $this->getReference('wine_' . $faker->numberBetween(1, $wine::WINE_COUNT - 1));
            $wine4 = $this->getReference('wine_' . $faker->numberBetween(1, $wine::WINE_COUNT - 1));

            $session->addWine($wine1);
            $session->addWine($wine2);
            $session->addWine($wine3);
            $session->addWine($wine4);

            $manager->persist($session);

            $this->addReference('session_' . $key, $session);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            WineFixtures::class,
        ];
    }
}
