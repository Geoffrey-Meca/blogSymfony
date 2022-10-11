<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\User;
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
                ->setImage("https://via.placeholder.com/150")
                ->setCreatedAt($faker->dateTime());

            $manager->persist($post);
        }

        // for ($i = 0; $i < 4; $i++) {
        //     $user = new User();
        //     $user->setEmail($faker->email())
        //         ->setFirstName($faker->firstName())
        //         ->setPassword($faker->password());

        //     $manager->persist($user);
        // }

        $manager->flush();
    }
}
