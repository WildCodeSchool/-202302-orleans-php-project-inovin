<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création d'un utilisateur
        $utilisator = new User();
        $utilisator->setEmail('utilisator@monsite.com');
        $utilisator->setRoles(['ROLE_UTILISATOR']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $utilisator,
            'utilisatorpassword'
        );
        $utilisator->setPassword($hashedPassword);
        $utilisator->setFirstname('Simple');
        $utilisator->setLastname('Utilisator');
        $utilisator->setDateBirth($faker->dateTime());

        $manager->persist($utilisator);

        // Création d'un administrateur
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminpassword'
        );
        $admin->setPassword($hashedPassword);
        $admin->setFirstname('Mike');
        $admin->setLastname('Xiong');
        $admin->setDateBirth($faker->dateTime());
        $manager->persist($admin);

        $manager->flush();
    }
}
