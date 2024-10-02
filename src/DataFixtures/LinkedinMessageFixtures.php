<?php

namespace App\DataFixtures;

use App\Entity\LinkedinMessage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LinkedinMessageFixtures extends Fixture
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
        
        // Créer 10 messages de Linkedin aléatoires
        for ($i = 0; $i < 10; $i++) {
            $message = new LinkedinMessage();
            $message
                ->setContent($faker->sentence)
                ->setCreatedAt($faker->DateTimeImmutable('now'))
                ->setUpdatedAt($faker->DateTimeImmutable('now'))
                ->setJobOffer($faker->randomElement($jobOffers))
                ->setAppUser($faker->randomElement($users));
            $manager->persist($message);
            $this->addReference('linkedin_message_' . $i, $message);
        }
        
        $manager->flush();
    }
}
