<?php

namespace App\Controller;

use App\Entity\Formulaire;
use App\Form\FormulaireType;
use App\Repository\FormulaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formulaire")
 */
class FormulaireController extends AbstractController
{
    /**
     * @Route("/liste", name="formulaire_index", methods="GET")
     */
    public function index(FormulaireRepository $formulaireRepository): Response
    {
        return $this->render('formulaire/index.html.twig', ['formulaires' => $formulaireRepository->findAll()]);
    }


    /**
     * @Route("/aurevoir", name="formulaire_index", methods="GET")
     */
    public function aurevoir(FormulaireRepository $formulaireRepository): Response
    {
        return $this->render('formulaire/aurevoir.html.twig', ['formulaires' => $formulaireRepository->findAll()]);
    }

    /**
     * @Route("/new", name="formulaire_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $formulaire = new Formulaire();
        $form = $this->createForm(FormulaireType::class, $formulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formulaire);
            $em->flush();

            return $this->redirectToRoute('formulaire_aurevoir');
        }

        return $this->render('formulaire/new.html.twig', [
            'formulaire' => $formulaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formulaire_delete", methods="DELETE")
     */
    public function delete(Request $request, Formulaire $formulaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formulaire->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($formulaire);
            $em->flush();
        }

        return $this->redirectToRoute('formulaire_index');
    }
}
