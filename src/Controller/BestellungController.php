<?php

namespace App\Controller;

use App\Entity\Bestellung;
use App\Entity\Gericht;
use App\Repository\BestellungRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestellungController extends AbstractController
{
    #[Route('/bestellung', name: 'app_bestellung')]
    public function index(BestellungRepository $bestellungRepository): Response
    {

        $bestellung = $bestellungRepository->findAll(
            ['tisch' => 'tisch1']
        );
        return $this->render('bestellung/index.html.twig', [
            'bestellungen' => $bestellung,
        ]);
    }

    #[Route('/bestellen/{id}', name: 'app_bestellen')]
    public function bestellen(Gericht $gericht, ManagerRegistry $doctrine): Response
    {
        $bestellung = new Bestellung();
        $bestellung->setTisch("tisch1");
        $bestellung->setName($gericht->getName());
        $bestellung->setBnummer($gericht->getId());
        $bestellung->setPreis($gericht->getPreis());
        $bestellung->setStatus("Offen");

        //EntityManager
        $em = $doctrine->getManager();
        $em->persist($bestellung);
        $em->flush();

        $this->addFlash('bestell', $bestellung->getName() . ' wurde zur Bestellung hinzugefügt');

        return $this->redirect($this->generateUrl('app_menu'));
    }

    #[Route('/status/{id},{status}', name: 'app_status')]
    public function status($id, $status, ManagerRegistry $doctrine){
        //EntityManager
        $em = $doctrine->getManager();
        $bestellung = $em->getRepository(Bestellung::class)->find($id);
        $bestellung->setStatus($status);
        $em->flush();

        return $this->redirect($this->generateUrl('app_bestellung'));
    }

    #[Route('/loschen/{id}', name: 'app_loschen')]
    public function entfernen($id, BestellungRepository $br, ManagerRegistry $doctrine){
         //EntityManager
         $em = $doctrine->getManager();
         $bestellung = $br->find($id);
         $em->remove($bestellung);
         //$em->persist($gericht); 
         $em->flush();

         
         return $this->redirect($this->generateUrl('app_bestellung'));
    }
}
