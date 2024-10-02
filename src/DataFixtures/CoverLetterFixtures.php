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
        for ($i = 0; $i < 100; $i++) {
            $coverLetter = new CoverLetter();
            $coverLetter
                ->setContent($faker->paragraph)
                ->setJobOffer($this->getReference('job_offer_' . $faker->numberBetween(1, 10)))
                ->setAppUser($this->getReference('app_user_' . $faker->numberBetween(1, 10)));
            $manager->persist($coverLetter);
            $this->addReference('cover_letter_' . $i, $coverLetter);
        }
        
        $manager->flush();
    }
}
