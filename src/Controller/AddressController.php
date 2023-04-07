<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressFormType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    #[Route('/address/create', name: 'create_address')]
    public function create_address(Request $request,EntityManagerInterface $entityManager): Response
    {
        $address =  new Address();

        $form = $this->createForm(AddressFormType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $address->setUser($this->getUser());
            }

            $entityManager->persist($address);
            $entityManager->flush();
            return $this->redirectToRoute('user_data');
        }

        return $this->render('address/add.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/address/edit/{id}', name: 'edit_address',  methods: ['GET','POST'])]
    public function edit_address (Request $request, AddressRepository $addressRepository, EntityManagerInterface $em, $id){
        $post = $addressRepository->find($id);

        //dd($post);
        $form = $this->createForm(AddressFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('user_data');
        }

        return $this->render('address/edit.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/address/delete/{id}', name: 'delete_address', methods: ['GET'])]
    public function delete_address(AddressRepository $addressRepository, Address $address): Response
    {
        $addressRepository->remove($address, true);

        return $this->redirectToRoute('user_data');
    }
}
