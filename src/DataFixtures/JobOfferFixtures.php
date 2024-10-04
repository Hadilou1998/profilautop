<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\JobOffer;
use DateTimeImmutable;

class JobOfferFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $statuses = ['Envoyée', 'En attente', 'Entretien programmé', 'Refusée', 'Acceptée'];

        for ($i = 0; $i < 20; $i++) {
            $jobOffer = new JobOffer();
            $jobOffer->setTitle($this->faker->jobTitle)
                ->setCompany($this->faker->company)
                ->setLink($this->faker->url)
                ->setLocation($this->faker->city)
                ->setSalary($this->faker->numberBetween(30000, 100000) . '€')
                ->setContactPerson($this->faker->name)
                ->setContactEmail($this->faker->companyEmail)
                ->setApplicationDate(new DateTimeImmutable($this->faker->dateTimeThisYear->format('Y-m-d')))
                ->setStatus($this->faker->randomElement($statuses))
                ->setAppUser($this->getReference('user_' . $this->faker->numberBetween(0, 9)));

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