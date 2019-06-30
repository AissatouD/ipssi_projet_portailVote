<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $userAdmin = new User();
            $userAdmin-> setFirstname($faker->firstName());
            $userAdmin-> setLastname($faker->lastName);
            $userAdmin-> setMail($faker->email);

            $password= $this->encoder->encodePassword($userAdmin, 'useruser');
            $userAdmin-> setPassword($password);
            $userAdmin-> setRoles(['ROLE_USER']);
            $userAdmin-> setStatut(true);
            $manager->persist($userAdmin);

            $manager->flush();
        }
    }
}
