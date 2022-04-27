<?php

namespace App\DataFixtures;

use App\Entity\Produits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProduitsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $items = ['starters','specialty','salads'];
        for($i=0;$i<20;$i++){
            $produit = new Produits();
            $produit
                ->setNom($faker->words(3,true))
                ->setDescription($faker->sentences(3,true))
                ->setPrix($faker->numberBetween(15,20))
                ->setType($items[rand(0, count($items) - 1)]);
                $manager->persist($produit);
                $manager->flush();

        }
    }
}
