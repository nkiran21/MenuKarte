<?php

namespace App\Controller;


use App\Repository\GerichtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function menu(GerichtRepository $gr): Response
    {
        $gerichte = $gr->findall();

        return $this->render('menu/index.html.twig', [
            'gerichte' => $gerichte,
        ]);
    }
}
