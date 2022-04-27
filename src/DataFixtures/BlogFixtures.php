<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($i=0;$i<4;$i++){
            $blog = new Blog();
            $blog
                ->setTitre($faker->words(3,true))
                ->setDescription($faker->sentences(10,true))
                ->setImage('specials-1.jpg');
                $manager->persist($blog);
                $manager->flush();

        }
    }
}
