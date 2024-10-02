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

        // Create cover letters
        for ($i = 0; $i < 50; $i++) {
            $coverLetter = new CoverLetter();
            $coverLetter
                ->setJobOffer($this->getReference('job_offer_' . $i))
                ->setAppUser($this->getReference('user_' . $i))
                ->setContent($faker->text(500));
            $manager->persist($coverLetter);
        }
        
        $manager->flush();
    }
}
