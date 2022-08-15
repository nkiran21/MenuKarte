<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Form\GerichtType;
use App\Repository\GerichtRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Controller\FileException;

#[Route('/gericht', name: 'app_gericht')]
class GerichtController extends AbstractController
{
    #[Route('/', name: 'app_bearbeiten')]
    public function index(GerichtRepository $gr): Response
    {
        $gerichte = $gr->findAll();
        
        return $this->render('gericht/index.html.twig', [
            'gerichte' => $gerichte
        ]);
    }

    #[Route('/anlegen', name: 'app_anlegen')]
    public function anlegen(Request $request, ManagerRegistry $doctrine){
        $gericht = new Gericht();

        //Formular    
        $form = $this->createForm(GerichtType::class, $gericht);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            //EntityManager
            $em = $doctrine->getManager();
            $bildFile = $form->get('anhang')->getData();
            if($bildFile){
                 //dd($bildFile);
              $dateiname = md5(uniqid()) . '.' .  $bildFile->guessExtension();
            }
           
           // dd($this->getParameter('bilder_ordner'));
            // Move the file to the directory where images are stored
            try {
                $bildFile->move(
                $this->getParameter('bilder_ordner'),
                $dateiname
                );
            } catch (BadRequestHttpException $e) {
                // ... handle exception if something happens during file upload
            }
            $gericht->setBild($dateiname);
            $em->persist($gericht);
            $em->flush();

            return $this->redirect($this->generateUrl('app_gerichtapp_bearbeiten'));
        }
        
        //Response
        return $this->render('gericht/anlegen.html.twig', [
            'anlegenForm' => $form->createView()
        ]);
    }

    #[Route('/anzeigen/{id}', name: 'app_anzeigen')]
    public function anzeigern(Gericht $gericht){
        return $this->render('gericht/anzeigen.html.twig', [
            'gericht' => $gericht
        ]);    }
}

