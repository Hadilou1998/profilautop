<?php

namespace App\DataFixtures;

use App\Entity\JobOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class JobOfferFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
    
        // Référence à l'utilisateur créé dans UserFixtures
        $this->addReference('user_0', $this->getReference('user_0'));
        
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
                ->setContactEmail($faker->email)
                ->setApplicationDate($faker->dateTimeBetween('-1 year', 'now'))
                ->setAppUser($this->getReference('user_' . rand(0, 1)));
            $manager->persist($jobOffer);
        }

        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}