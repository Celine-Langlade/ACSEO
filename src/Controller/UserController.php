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
             $user = new User();
             $form = $this->createForm(UserType::class, $user);
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
                 $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                 $user->setPassword($password);
                 $user->setIsActive(true);
                 $user->addRole("ROLE_ADMIN");
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($user);
                 $entityManager->flush();

                 $this->addFlash('success', 'Votre compte à bien été enregistré. Veuillez vous identifier pour vous connecter à l\'interface');
                 return $this->redirectToRoute('login');
             }
             return $this->render('user/register.html.twig', ['form' => $form->createView(), 'mainNavUser' => true, 'title' => 'Inscription']);
         }
}
