<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\String\Slugger\SluggerInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $count = $this->faker->numberBetween(20, 40);
        for ($a = 0; $a < $count; $a++) {
            $randomPostId = $this->faker->numberBetween(0, 9);
            /** @var Topic $randomPost */
            $randomPost = $this->getReference('post-' . $randomPostId);

            $this->createComment($manager,$randomPost);
        }

        $manager->flush();
    }

    public function createComment(ObjectManager $manager, Topic $post)
    {
        $randomUserId = $this->faker->numberBetween(0, 4);
        /** @var User $randomUser */
        $randomUser = $this->getReference('user-' . $randomUserId);

        $minDate = $post->getPubished_Date()->format('c');

        $date = \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween($minDate, 'now'));

        $comment = new Comment();
        $comment->setAuthor($randomUser);
        $comment->setContent($this->faker->realText());
        $comment->setDate($date);
        $comment->setTopic($post);

        $manager->persist($comment);
        return $comment;
    }

    public function getDependencies(): array
    {
        return [
            TopicFixtures::class,
            UserFixtures::class,
        ];
    }
}
