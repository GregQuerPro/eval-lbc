<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AnnonceController extends AbstractController
{

    #[Route('/annonces/{id}', name: 'annonce_single')]
    public function single($id, AnnonceRepository $repository) {
        $annonce = $repository->find($id);

        return $this->render('annonce/single.html.twig', [
            'annonce' => $annonce
        ]);
    }

    #[Route('/annonce/add', name: 'annonce_add')]
    public function create(Request $request, EntityManagerInterface $em, Security $security): Response
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
            $user = $security->getUser();
            $annonce
                ->setUser($user)
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


    #[Route('/annonce/edit/{id}', name: 'annonce_edit')]
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

    #[Route('/annonce/delete/{id}', name: 'annonce_delete')]
    public function delete(EntityManagerInterface $em, Annonce $annonce): Response
    {
        $em->remove($annonce);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
