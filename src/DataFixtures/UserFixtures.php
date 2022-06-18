<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{

    private Generator $faker;

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(5, 10);
        for ($a = 0; $a < $count; $a++) {
            $this->createUser($manager);
        }
        $this->createUser($manager, [
            'email' => 'florian.champie@gmail.com',
            'firstname' => 'Florian',
            'lastname' => 'Champie',
            'password' => 'flocha',
            'roles' => ['ROLE_AUTHOR', 'ROLE_ADMINISTRATOR'],
        ]);

        $manager->flush();
    }
    public function createUser(ObjectManager $manager, array $data = [])
    {
        static $index = 0;

        $data = array_replace(
            [
                'email' => $this->faker->email(),
                'firstname' => $this->faker->firstName(),
                'lastname' => $this->faker->lastName(),
                'password' => $this->faker->password(),
                'adress' => $this->faker->address(),
                'zip_code' => $this->faker->postcode(),
                'city' => $this->faker->city(),
                'phone' => $this->faker->phoneNumber(),
                'pseudo' => $this->faker->password(),
                'roles' => ['ROLE_AUTHOR'],
            ],
            $data,
        );
        $user = (new User())
            ->setMail($data['email'])
            ->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setAdress($data['adress'])
            ->setZipCode($data['zip_code'])
            ->setCity($data['city'])
            ->setPhone($data['phone'])
            ->setPseudo($data['pseudo'])
            ->setRoles($data['roles'])
            ->setActivated(true);

        $user->setPassword($this->passwordEncoder->hashPassword($user, $data['password']));
        $manager->persist($user);
        $this->setReference('user-' . $index++, $user);
    }

}
