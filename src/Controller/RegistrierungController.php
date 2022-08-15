<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;

class RegistrierungController extends AbstractController
{
    #[Route('/reg', name: 'app_reg')]
    public function reg(Request $request, UserPasswordHasherInterface $passEncoder, ManagerRegistry $doctrine): Response
    {
        $regForm = $this->createFormBuilder()
        ->add('username',TextType::class,[
            'label' => 'Mitarbeiter'])
        ->add('password',RepeatedType::class,[
            'type' => PasswordType::class,
            'required' => true,
            'first_options'=> ['label' => 'Password'],
            'first_options'=> ['label' => 'Password_Widerholen'],
            ])
        ->add('registrieieren', SubmitType::class)
        ->getForm();

        $regForm->handleRequest($request);

        if($regForm->isSubmitted()){
            $eingabe = $regForm->getData();
            
            $user = new User;
            $user->setUsername($eingabe['username']);

            $user->setPassword(
                $passEncoder->hashPassword($user, $eingabe['password'])
            );

           //EntityManager
           $em = $doctrine->getManager();
           $em->persist($user);
           $em->flush();
           return $this->redirect($this->generateUrl('app_home'));

        }

        return $this->render('registrierung/index.html.twig', [
            'regform' => $regForm->createView(),
        ]);
    }
}
