<?php

namespace App\DataFixtures;

use Faker\Factory;
// use Faker\Generator;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

public function load(ObjectManager $manager): void
        {
            $faker= Factory::create('fr_FR');
        for ($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article ->setTitle ($faker->words(3, true))
                    ->setContent ($faker->paragraph())
                    ->setAutor ($faker->words(2, true))
                    ->setDate ($faker->dateTime());  
                    $manager->persist($article);  
                    $manager->flush(); 
            }

     
    }
}

