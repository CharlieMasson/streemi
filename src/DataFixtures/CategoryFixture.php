<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $category = new Category();
        $category->setName("comedie");
        $category->setLabel("Comédie");
        $manager->persist($category);
        $category->setName("horreur");
        $category->setLabel("Horreur");
        $manager->persist($category);
        
        $manager->flush();
    }
}