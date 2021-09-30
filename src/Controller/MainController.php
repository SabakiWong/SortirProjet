<?php

namespace App\Controller;

use App\Data\InfoRecherche;
use App\Entity\Utilisateur;
use App\Form\GererMonProfilType;
use App\Form\RechercheType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Profiler\Profile;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_accueil")
     */
     public function accueil(SortieRepository $sortieRepository, Request $request) {

         //On récupère les sorties par ordre chronologique
         $sorties = $sortieRepository->findBy([],['dateHeureDebut'=>'DESC']);

        //Traitement de la recherche filtrée

         //Je crée un objet qui va stocker mes infos de recherche
         $infoRecherche = new InfoRecherche();
         $form = $this->createForm(RechercheType::class, $infoRecherche);

         //On renvoie nos résultats au fichier twig
         return $this->render('main/accueil.html.twig', [
             'sorties'=>$sorties,
             'form' => $form->createView()
         ]);
     }




}