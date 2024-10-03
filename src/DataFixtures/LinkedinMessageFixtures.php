<?php

namespace App\DataFixtures;

use App\Entity\LinkedinMessage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LinkedinMessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        // Get job offers from references
        $jobOffers = [];
        for ($i = 0; $i < 10; $i++) {
            $jobOffers[] = $this->getReference('job_offer_' . $i);
        }
        
        // Référence les messages aux job offres
        for ($i = 0; $i < count($jobOffers); $i++) {
            $jobOffers[$i]->addLinkedinMessage($this->getReference('linkedin_message_' . $i));
        }
        
        $manager->flush();
        
        // Associer les messages aux job offres
        foreach ($jobOffers as $jobOffer) {
            $manager->refresh($jobOffer);
        }
        
        // Créer 10 messages de Linkedin aléatoires
        for ($i = 0; $i < 10; $i++) {
            $message = new LinkedinMessage();
            $message
                ->setContent($faker->sentence)
                ->setCreatedAt($faker->dateTimeImmutable('now'))
                ->setUpdatedAt($faker->dateTimeImmutable('now'))
                ->setJobOffer($faker->randomElement($jobOffers));
            $manager->persist($message);
            $this->addReference('linkedin_message_' . $i, $message);
        }
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            JobOfferFixtures::class,
        ];
    }
}