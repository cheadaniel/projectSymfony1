<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/dashboard', name: 'user_data')]
    public function user(UserRepository $userRepository): Response
    {
        // $user = $userRepository->find($id);

        return $this->render('user/index.html.twig', [
            // 'user' => $user,
        ]);
    }
}
