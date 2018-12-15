<?php

namespace App\Controller;

use App\Entity\Formulaire;
use App\Form\FormulaireType;
use App\Repository\FormulaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends Controller {

    /**
     * @Route("/")
     */
    public function index(FormulaireRepository $formulaireRepository): Response
    {
      return $this->render('formulaire/index.html.twig', ['formulaires' => $formulaireRepository->findAll()]);
    }

}
