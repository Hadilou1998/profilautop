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
        $user = new User();
        $user
            ->setEmail('admin@admin.com')
            ->setPassword($this->hasher->hashPassword($user, 'admin'))
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setImage($faker->imageUrl(640, 480, 'people', true))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($user);
        $manager->flush();
    }
}