<?php

namespace App\Repository;

use App\Data\InfoRecherche;
use App\Entity\Sortie;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function findCreatedSortie(){
        //Requête DQL
        $entityManager = $this->getEntityManager();
        $dql = "
                SELECT s
                FROM App\Entity\Sortie s
                ORDER BY s.id DESC
                ";
        $query = $entityManager->createQuery($dql);
        $query->setMaxResults(1);
        return $query->getOneOrNullResult();
    }


    /**
     * Cette fontction récupère les sorties reliées à une recherche
     * @return Sortie[]
     */
    public function findSortie(InfoRecherche $infoRecherche) : array {

        $queryBuilder = $this->createQueryBuilder('s'); //Je passe l'alias de l'entité

        $queryBuilder->select('s');

        //Filtrage par campus
        $queryBuilder = $queryBuilder
            ->andWhere('s.campus = :idCampus')
            ->setParameter('idCampus', $infoRecherche->campus);

        //Si l'utilisateur rentre quelquechose dans la barre de recherche
        if (!empty($infoRecherche->motCle)) {
            $queryBuilder = $queryBuilder
                ->andWhere('s.nom LIKE :motCle')
                ->setParameter('motCle', "%{$infoRecherche->motCle}%");
        }

        //Si l'utilisateur coche la case d'organisateur
        if ($infoRecherche->estOrganisateur == true) {

            //$user->getId(); Utilisateur $user

            $queryBuilder = $queryBuilder
                ->andWhere('s.campus.id = :idCampus')
                ->setParameter('idCampus', $infoRecherche->campus);
        }
        //dd($queryBuilder);
        $queryBuilder->orderBy('s.dateHeureDebut', 'DESC');
        $query = $queryBuilder->getQuery();

        $query->setMaxResults(10);
        $results = $query->getResult();

        return $results;
    }

    public function findSortieToCancel(int $id){
        //Requête QueryBuilder
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder->join("s.campus", "c");
        $queryBuilder->join("s.lieu", "l");
        $queryBuilder->join("l.ville", "v");
        $queryBuilder->addSelect('c', 'l', 'v');
        $queryBuilder->where("s.id = :id");
        $queryBuilder->setParameter('id', $id);
        $query = $queryBuilder->getQuery();
        return $query->getResult();



        //Requête DQL
        //$entityManager = $this->getEntityManager();
        //$dql = "
               // SELECT s.nom, s.dateHeureDebut, s.campus, s.lieu, s.motif
                //FROM App\Entity\Sortie s
              //  ";
        //$query = $entityManager->createQuery($dql);
       // return $query->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
