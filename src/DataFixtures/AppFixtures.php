<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle($faker->sentence())
                ->setContent($faker->paragraph())
                ->setAuthor($faker->name())
                ->setCreatedAt($faker->dateTime());

            $manager->persist($post);
        }

        $manager->flush();
    }
}
