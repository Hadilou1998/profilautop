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

        // References des utilisateurs
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = $this->getReference('user_'. $i);
        }
        
        // Associer les utilisateurs aux job offres
        foreach ($users as $user) {
            $manager->refresh($user);
        }

        // Create 50 job offers aléatoires
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
                ->setStatus($faker->randomElement(['applied', 'interviewing', 'rejected', 'offered']))
                ->setAppUser($this->getReference('user_' . $faker->numberBetween(0, 9)));
            $manager->persist($jobOffer);
            $this->addReference('job_offer_' . $i, $jobOffer);
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