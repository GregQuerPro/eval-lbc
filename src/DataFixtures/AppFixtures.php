<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        
        // $category = new Category();
        // $category->setTitle('Category #2');

        // $em->persist($category);

        // $annonce = new Annonce();
        // $annonce
        //     ->setTitle('Title #3')
        //     ->setDescription('Description #3')
        //     ->setPrice(23)
        //     ->setCreatedAt(new DateTimeImmutable())
        //     ->setUpdatedAt(new DateTimeImmutable())
        //     ->setCategory($category);

        // $em->persist($annonce);
        // $em->flush();

    }
}
