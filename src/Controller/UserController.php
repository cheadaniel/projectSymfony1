<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'user_data')]
    public function user(UserRepository $userRepository, $id): Response
    {
        $user = $userRepository->find($id);

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
