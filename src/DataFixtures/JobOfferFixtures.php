<?php

namespace App\DataFixtures;

use App\Entity\JobOffer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class JobOfferFixtures extends Fixture
{
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $user = $manager->getRepository(User::class)->findOneBy([]);

        if (!$user) {
            $user = new User();
            $manager->persist($user);
        }

        // Create 50 job offers aléatoires
        for ($i = 0; $i < 50; $i++) {
            $jobOffer = new JobOffer();
            $jobOffer
                ->setTitle($faker->jobTitle)
                ->setCompany($faker->company)
                ->setLink($faker->url)
                ->setLocation($faker->city)
                ->setSalary($faker->numberBetween(1000, 10000))
                ->setContactPerson($faker->name)
                ->setContactEmail($faker->contactEmail) // Corrected line
                ->setApplicationDate($faker->dateTimeBetween('-1 year', 'now'))
                ->setStatus($faker->randomElement(['pending', 'accepted', 'rejected']));
            $manager->persist($jobOffer);
            $this->addReference('user_' . $i, $jobOffer);
        }

        $manager->flush();
    }
}