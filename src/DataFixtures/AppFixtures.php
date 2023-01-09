<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class AppFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $categories = [];

        for ($a = 1; $a <= 5; $a++) {
         $category = new Category();
         $category->setTitle("Category #$a");
         $categories[] = $category;
         $manager->persist($category);
        }


        $user = new User();
        $user
            ->setUsername('username')
            ->setRoles([])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'password'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        for ($a = 1; $a < 30; $a++) {
         $annonce = new Annonce();
         $annonce
             ->setTitle("Title #$a")
             ->setDescription("Description #$a")
             ->setPrice(23)
             ->setCreatedAt(new \DateTimeImmutable())
             ->setUpdatedAt(new \DateTimeImmutable())
             ->setCategory($categories[rand(0,4)])
             ->setUser($user)
             ->setImageName('ps5.jpg');
         $manager->persist($annonce);
        }

         $manager->flush();

    }
}
