<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\String\Slugger\SluggerInterface;


class TopicFixtures extends Fixture implements DependentFixtureInterface
{

    private Generator $faker;

    public function __construct(private SluggerInterface $slugger)
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(10, 30);
        for ($a = 0; $a < $count; $a++) {
            $randomUserId = $this->faker->numberBetween(0, 4);
            
            /** @var User $randomUser */
            $randomUser = $this->getReference('user-' . $randomUserId);

            $title = $this->faker->sentence(10);

            $post = (new Topic())
                ->setTitle($title)
                ->setSlug($this->slugger->slug($title)->lower())
                ->setPubished_Date($this->faker->dateTime())
                ->setContent($this->faker->realText(1000))
                ->setAuthor($randomUser);

            $manager->persist($post);
            $this->setReference('post-' . $a, $post);

            $manager->flush();
        }
    }

    public function getDependencies() : array
    {
        return [
            UserFixtures::class,
        ];
    }

}
