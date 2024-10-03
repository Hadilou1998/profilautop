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
            ->setEmail('merlin@profiluser.fr')
            ->setPassword($this->hasher->hashPassword($user, 'sorcier'))
            ->setRoles(['ROLE_USER'])
            ->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setImage($faker->imageUrl(640, 480, 'people', true));
        $manager->persist($user);
        $this->addReference('user_', $user); // Reference to the first user for other fixtures (CoverLetter, JobOffer, LinkedInMessage)

        // Create more users
        for ($i = 2; $i <= 10; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email)
                ->setPassword($this->hasher->hashPassword($user, 'password' . $i))
                ->setRoles(['ROLE_USER'])
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setImage($faker->imageUrl(640, 480, 'people', true));
            $manager->persist($user);
            $this->addReference('user_'. $i, $user); // Reference to the other users for other fixtures (CoverLetter, JobOffer, LinkedInMessage)
        }

        $manager->flush();
    }
}