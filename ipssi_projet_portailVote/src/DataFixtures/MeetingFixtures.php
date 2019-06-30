<?php

namespace App\DataFixtures;

use App\Entity\Meeting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class MeetingFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 100; $i++) {

            $faker = Faker\Factory::create('fr_FR'); // create a French faker
            $meetingFixture = new Meeting();
            $meetingFixture->setTitle($faker->words(3, true));
            $meetingFixture->setDescription($faker->sentence(10, true));
            $meetingFixture->setLocation($faker->city);
            $meetingFixture->setDate($faker->dateTime);
            $meetingFixture->setNote($faker->numberBetween(0, 5));
        }


            $manager->persist($meetingFixture);

        $manager->flush();
    }
}
