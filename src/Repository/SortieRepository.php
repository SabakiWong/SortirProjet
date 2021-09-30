<?php

namespace App\Repository;

use App\Entity\Sortie;
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
    public function findSortie() : array {
        //Avec le QueryBuilder
        $queryBuilder = $this->createQueryBuilder('s'); //Je passe l'alias de l'entité

        $queryBuilder->andWhere();
        $queryBuilder->orderBy('s.dateHeureDebut', 'DESC');
        $query = $queryBuilder->getQuery();

        $query->setMaxResults(10);
        $results = $query->getResult();

        return $results;
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
