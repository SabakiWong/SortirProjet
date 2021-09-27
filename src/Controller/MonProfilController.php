<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\GererMonProfilType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonProfilController extends AbstractController
{
    /**
     * @Route("/mon/profil", name="mon_profil")
     */
    public function index(): Response
    {
        return $this->render('mon_profil/index.html.twig', [
            'controller_name' => 'MonProfilController',
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request, EntityManagerInterface $entityManager, string $photoDir,
                           UtilisateurRepository $utilisateurRepository):Response
    {
        //$user = $this->getUser();
        $user= new Utilisateur();
        //$user  = $utilisateurRepository -> afficherUtilisateur();
        $user = $utilisateurRepository->find(0);
       // $user->
        $user  = $utilisateurRepository -> afficherUtilisateur()[0] ;

        var_dump($user);
        //appel l'utilisateur
        $profilForm = $this->createForm(GererMonProfilType::class, $user);

        //Récupération des données de l'utilisateur de la BDD


        // $user = $utilisateurRepository -> afficherUtilisateur();


        //Traitement du formulaire
        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted())
        {
            $entityManager->persist($profilForm);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil à bien été modifié !');
            /* if ($photo = $profilForm['photo']->getData())
              {
                  //Il enregistre la photo dans un fichier
                  //le random_bytes sert pour donner un nom aléatoire au fichier
                  $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                                  try {
                                      $photo->move($photoDir, $filename);
                                  } catch (FileException $e) {
                                     // unable to upload the photo, give up
                                  }
              }*/
        }
        return $this->render('main/profil.html.twig', [
            'profilForm'=> $profilForm->createView(),
            'user'=> $user

        ]);
    }
}
