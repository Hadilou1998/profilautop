<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Create users
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setPassword($faker->password)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setCreatedAt(new \DateTimeImmutable($faker->dateTimeThisYear->format('Y-m-d H:i:s')))
                ->setUpdatedAt(new \DateTimeImmutable($faker->dateTimeThisMonth->format('Y-m-d H:i:s')))
                ->setImage($faker->imageUrl(200, 200, 'people'))
                ->setRoles(['ROLE_USER']);

            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }
    }
}