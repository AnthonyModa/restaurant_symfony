<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Restaurant;
use App\Entity\Avis;


class RestaurantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Créer 3 fakes catégories de restaurant (français, italien et asiatique)
        $categories = ['Français', 'Italien', 'Asiatique'];
        for($i=1; $i <= 2; $i++) {
            $category = new Category();
            $category ->setTitle($categories[$i]);
        }

            //Créer entre 2 et 4 restos
            for($j =1; $j < mt_rand(2,4); $j++){
                $restaurant = new Restaurant();

                $description = '<p>' . join($faker->paragraphs(5), '</p><p>' . '</p>');

                $informations = '<p>' . join($faker->paragraphs(2), '</p><p>' . '</p>');

                $avis = '<p>' . join($faker->paragraphs(1), '</p><p>' . '</p>');





                $restaurant->setTitre($faker->sentence())
                           ->setDescription($description)
                           ->setInformations($informations)
                           ->setAvis($avis)
                           ->setImage("http://lorempixel.com/400/200/food")
                           ->setCategory($category);
                $manager->persist($restaurant);

            }

        $manager->flush();
    }
}
