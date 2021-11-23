<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_NAME = "category-1";

    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName("Articles");
        
        $this->addReference(self::CATEGORY_NAME, $category);

        $manager->persist($category);
        $manager->flush();

    }
}

