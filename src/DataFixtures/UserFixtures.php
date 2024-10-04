<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use DateTimeImmutable;

class UserFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email)
                ->setPassword($this->faker->password)
                ->setFirstName($this->faker->firstName)
                ->setLastName($this->faker->lastName)
                ->setCreatedAt(new DateTimeImmutable($this->faker->dateTimeThisYear->format('Y-m-d H:i:s')))
                ->setUpdatedAt(new DateTimeImmutable($this->faker->dateTimeThisMonth->format('Y-m-d H:i:s')))
                ->setImage($this->faker->imageUrl(200, 200, 'people'))
                ->setRoles(['ROLE_USER']);

            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}