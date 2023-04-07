<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Form\AnnonceFormType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonces', name: 'annonces')]
    // recupere toutes les annonces et les transmet a la page qui affiche toutes les annonces
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAll();
        //dd($annonces);
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    #[Route ('/annonce/create', name:'create_annonce')]
    public function create_annonce(Request $request, EntityManagerInterface $entityManager): Response 
    {
        $annonce = new Annonce();

        $form = $this->createForm(AnnonceFormType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $annonce->setUser($this->getUser());
            }
            $annonce->setIsVisible(true);

            $entityManager->persist($annonce);
            $entityManager->flush();
            return $this->redirectToRoute('user_data');
        }
        return $this->render('annonce/add.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/annonce/edit/{id}', name: 'edit_annonce',  methods: ['GET','POST'])]
    public function edit_annonce (Request $request, AnnonceRepository $annonceRepository, EntityManagerInterface $em, $id){
        $post = $annonceRepository->find($id);

        //dd($post);
        $form = $this->createForm(AnnonceFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('user_data');
        }

        return $this->render('annonce/edit.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/annonce/delete/{id}', name: 'delete_annonce', methods: ['GET'])]
    public function delete_address(AnnonceRepository $annonceRepository, Annonce $address): Response
    {
        $annonceRepository->remove($address, true);

        return $this->redirectToRoute('user_data');
    }

    #[Route('annonce/{id}', name:'annonce')]
    public function annonce(AnnonceRepository $annonceRepository,$id): Response
    {
        $annonce = $annonceRepository->find($id);
        //dd($annonces);
        return $this->render('annonce/annonce.html.twig', [
            'annonce' => $annonce,
        ]);
    }
}
