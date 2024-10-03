<?php

namespace App\DataFixtures;

use App\Entity\CoverLetter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CoverLetterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Get job offers and users from references
        $jobOffers = [];
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $jobOffers[] = $this->getReference('job_offer_' . $i);
            $users[] = $this->getReference('user_' . $i);
        }

        // Create 100 cover letters
        for ($i = 0; $i < 100; $i++) {
            $coverLetter = new CoverLetter();
            $coverLetter
                ->setContent($faker->text)
                ->setCreatedAt($faker->dateTimeImmutable)
                ->setUpdatedAt($faker->dateTimeImmutable)
                ->setJobOffer($jobOffers[$faker->numberBetween(0, 49)])
                ->setAppUser($users[$faker->numberBetween(0, 9)]);
            $manager->persist($coverLetter);
        }
        
        $manager->flush();
    }
}