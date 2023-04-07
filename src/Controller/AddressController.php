<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    #[Route('/address', name: 'edit_address')]
    public function edit_address(Request $request,EntityManagerInterface $entityManager): Response
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

        return $this->render('address/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
