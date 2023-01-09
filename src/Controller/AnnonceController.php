<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonce/add', name: 'annonce_add')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $annonce = new Annonce;
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash(
                'success',
                'Nouvelle annonce crée avec succès!'
            );

            $annonce = $form->getData();
            $annonce
                ->setCreatedAt(new DateTimeImmutable())
                ->setUpdatedAt(new DateTimeImmutable());
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('annonce/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/annonce/edit', name: 'annonce_edit')]
    public function edit(Request $request, EntityManagerInterface $em, Annonce $annonce): Response
    {
        
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash(
                'success',
                'Nouvelle annonce crée avec succès!'
            );

            $annonce = $form->getData();
            $annonce
                ->setUpdatedAt(new DateTimeImmutable());
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('annonce/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
