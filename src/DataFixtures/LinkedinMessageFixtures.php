<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\LinkedInMessage;
use DateTimeImmutable;

class LinkedInMessageFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 30; $i++) {
            $message = new LinkedInMessage();
            $message->setContent($this->faker->paragraph)
                ->setCreatedAt(new DateTimeImmutable($this->faker->dateTimeThisYear->format('Y-m-d H:i:s')))
                ->setUpdatedAt(new DateTimeImmutable($this->faker->dateTimeThisMonth->format('Y-m-d H:i:s')))
                ->setJobOffer($this->getReference('job_offer_' . $this->faker->numberBetween(0, 19)))
                ->setAppUser($this->getReference('user_' . $this->faker->numberBetween(0, 9)));

            $manager->persist($message);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            JobOfferFixtures::class,
        ];
    }
}