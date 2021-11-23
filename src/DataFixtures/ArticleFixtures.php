<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i <= 10; $i++) {
            $article = new Article();
            $article
            ->setTitle("Titre de l'article n° $i")
            ->setContent("<p>Contenu de l'article n° $i</p>")
            ->setImage("http://placehold.it/350x150")
            ->setCreatedAt(new \DateTime())
            ->setCategory($this->getReference(CategoryFixtures::CATEGORY_NAME));
            ;
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
