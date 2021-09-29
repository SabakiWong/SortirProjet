<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Entity\Utilisateur;
use App\Form\AnnulerSortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CancelSortieController extends AbstractController
{
    /**
     * @Route("/cancel", name="cancel_sortie")
     */
    public function cancel(
        Request $request,
        EtatRepository $etatRepository,
        UtilisateurRepository $utilisateurRepository,
        SortieRepository $sortieRepository
    ): Response
    {
        //Récupérer la sortie par son id et l'attribuer à l'objet $sortie
        $sortie = new Sortie();
      //  $idSortie = $sortie->getId();
        $sortie = $sortieRepository->findOneBy(['id'=>1]);

        //Créer le formulaire et remplir les infos de la sortie
        $form = $this->createForm(AnnulerSortieType::class, $sortie);
        //$sortie->setNom($sortie->getNom());
        //$sortie->setDateHeureDebut($sortie->getDateHeureDebut());
        //$sortie->setCampus($sortie->getCampus());
        //$sortie->setLieu($sortie->getLieu());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Récupération de l'id de l'utilisateur connecté
            $utilisateur = new Utilisateur();
            $idUser = $this->getUser()->getId();

            //Si l'utilisateur connecté est l'organisateur de la sortie, alors il peut annuler la sortie
            if($idUser == $sortie->getOrganisateur()->getId()){
                //Changement de l'état de la sortie à : Annulée
                $etat = new Etat();
                $etat = $etatRepository->findOneBy(['id' => 6]);
                $sortie->setEtat($etat);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($sortie);
                $manager->flush();

                //Affichage d'un message de succès
                $this->addFlash('success', 'La sortie a bien été annulée !');
            }else{
                //Affichage d'un message d'erreur
                $this->addFlash('error', 'La sortie ne peut être annulée que par son organisateur !');
            }
        }

            return $this->render('cancel_sortie/cancel.html.twig', [
                'form' => $form->createView(),
                'sortie'=>$sortie
            ]);
        }
}
