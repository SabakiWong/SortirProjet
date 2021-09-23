<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublierSortieController extends AbstractController
{
    /**
     * @Route ("/publish" , name="publierSortie_publish")
     */
    public function publish(EtatRepository $etatRepository, SortieRepository $sortieRepository): Response{
        //Hydrater les propriétés absentes du formulaire
        $sortie = new Sortie();
        $etat = new Etat();
        $etat = $etatRepository->findOneBy(['id'=>2]);
        $sortie->setEtat($etat);

        //Chercher les sorties dans la BDD
        $sortie = $sortieRepository->findPublishedSortie();

        return $this->render('main/accueil.html.twig', [
            "sortie" => $sortie
        ]);

    }
}