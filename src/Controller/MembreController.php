<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/membre") */
class MembreController extends Controller {

    /**
     * @Route("/")
     */
    public function index() {
        return $this->render('user/membre.html.twig', ['mainNavMember'=>true, 'title'=>'Espace Membre']);
    }

} ?>
