<?php

namespace App\DataFixtures;

use App\Entity\CoverLetter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CoverLetterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Reference to the User fixtures
        $this->addReference('user_', $this->getReference('user_0'));

        // Reference to the JobOffer fixtures
        for ($i = 0; $i < 50; $i++) {
            $this->addReference('job_offer_' . $i, $this->getReference('job_offer_'. $i));
        }

        // Create 50 cover letters
        for ($i = 0; $i < 50; $i++) {
            $coverLetter = new CoverLetter();
            $coverLetter
                ->setContent($faker->paragraphs(3, true))
                ->setAppUser($this->getReference('user_' . $i))
                ->setJobOffer($this->getReference('job_offer_' . $i));
            $manager->persist($coverLetter);
        }
        
        $manager->flush();
    }
}