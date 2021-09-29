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
        return $this->render('mon_profil/cancel.html.twig', [
            'controller_name' => 'MonProfilController',
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request, EntityManagerInterface $entityManager, string $photoDir,
                           UtilisateurRepository $utilisateurRepository):Response
    {
        //Récupère les données de l'utilisateur dans la base de données
        $idUser = $this->getUser()->getId();
        $userBase = $utilisateurRepository->find($idUser);

        $userForm= new Utilisateur();


        $userForm->setId($userBase->getId());
        $userForm->setPseudo($userBase->getPseudo());
        $userForm->setPrenom($userBase->getPrenom());
        $userForm->setNom($userBase->getNom());
        $userForm->setTelephone($userBase->getTelephone());
        $userForm->setEmail($userBase->getEmail());
        $userForm->setCampus($userBase->getCampus());


        $profilForm = $this->createForm(GererMonProfilType::class, $userForm);



        //Traitement du formulaire
        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted())
        {
            $utilisateurRepository->upgradeuser($userForm);
            // $entityManager->persist($profilForm);
          // $entityManager->flush();


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
            'user'=> $userForm
        ]);
    }
}
