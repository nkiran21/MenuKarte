<?php

namespace App\Controller;

use App\Repository\GerichtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(GerichtRepository $gr): Response
    {
        $gerichte = $gr->findAll();
        $zufall = array_rand($gerichte, 2);
        //dump($gerichte[$zufall[0]]);
        //dump($gerichte[$zufall[1]]);
        return $this->render('home/index.html.twig', [
            'gericht1' => $gerichte[$zufall[0]],
            'gericht2' => $gerichte[$zufall[1]],
        ]);
    }
    

    
}
