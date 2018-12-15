<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="registerAction")
     */
     public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
             // 1) build the form
             $user = new User();
             $form = $this->createForm(UserType::class, $user);
             // 2) handle the submit (will only happen on POST)
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
                 // 3) Encode the password (you could also do this via Doctrine listener)
                 $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                 $user->setPassword($password);
                 //on active par défaut
                 $user->setIsActive(true);
                 //$user->addRole("ROLE_ADMIN");
                 // 4) save the User!
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($user);
                 $entityManager->flush();
                 // ... do any other work - like sending them an email, etc
                 // maybe set a "flash" success message for the user
                 $this->addFlash('success', 'Votre compte à bien été enregistré.');
                 //return $this->redirectToRoute('login');
             }
             return $this->render('user/register.html.twig', ['form' => $form->createView(), 'mainNavUser' => true, 'title' => 'Inscription']);
         }
}
