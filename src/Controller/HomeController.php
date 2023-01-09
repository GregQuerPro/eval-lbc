<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Category;
use App\Entity\Product;
use App\Repository\AnnonceRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AnnonceRepository $annonceRepository, EntityManagerInterface $em): Response
    {

        $annonces = $annonceRepository->findAllJoinedToCategory();

        // dd($annonces);
        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}
