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
                ->setContent($faker->text(500))
                ->setAppUser($this->getReference($manager))
                ->setJobOffer($this->getReference('job' . $i));
            $manager->persist($coverLetter);
            $this->addReference('cover_letter_' . $i, $coverLetter);
        }
        
        $manager->flush();
    }
}
