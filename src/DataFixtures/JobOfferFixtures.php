<?php

namespace App\DataFixtures;

use App\Entity\JobOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class JobOfferFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Create 50 job offers
        for ($i = 0; $i < 50; $i++) {
            $jobOffer = new JobOffer();
            $jobOffer
                ->setTitle($faker->jobTitle)
                ->setCompany($faker->company)
                ->setLink($faker->url)
                ->setLocation($faker->city)
                ->setSalary($faker->numberBetween(1000, 100000))
                ->setContactPerson($faker->name)
                ->setContactEmail($faker->email)
                ->setApplicationDate($faker->dateTimeBetween('-1 year', 'now'))
                ->setStatus($faker->randomElement(['applied', 'interviewing', 'rejected', 'offered']));
            $manager->persist($jobOffer);
            $this->addReference('job_offer_' . $i, $jobOffer);
        }

        $manager->flush();
    }
}
