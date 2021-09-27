<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\GererMonProfilType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Profiler\Profile;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_accueil")
     */
     public function accueil(SortieRepository $sortieRepository) {
         $sorties = $sortieRepository->findAll();

         return $this->render('main/accueil.html.twig', [
             'sorties'=>$sorties
         ]);
     }




}