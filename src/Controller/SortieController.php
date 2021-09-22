<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController {

    /**
     * @Route ("/create" , name="sortie_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Hydrater les propriétés absentes du formulaire
            $sortie->setEtat();

            //Sauvegarder en bdd
            $entityManager->persist($sortie);
            $entityManager->flush();

            //Affichage d'un message de succès
            $this->addFlash('success', 'La sortie a bien été ajoutée !');

            //Redirection vers la page d'accueil
            return $this->redirectToRoute('main_accueil');
        }

        //Affichage du formulaire
        return $this->render('sortie/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}