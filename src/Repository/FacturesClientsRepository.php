<?php

namespace App\Repository;

use App\Entity\FacturesClients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method FacturesClients|null find($id, $lockMode = null, $lockVersion = null)
 * @method FacturesClients|null findOneBy(array $criteria, array $orderBy = null)
 * @method FacturesClients[]    findAll()
 * @method FacturesClients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturesClientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacturesClients::class);
    }

    // /**
    //  * @return FacturesClients[] Returns an array of FacturesClients objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FacturesClients
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function OrderByPriceDQL()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select m from App\Entity\FacturesClients m order by m.nomClient DESC');
        return $query->getResult();
    }
    public function OrderByPriceDQL2()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select m from App\Entity\FacturesClients m order by m.nomClient ASC');
        return $query->getResult();
    }


    public function getART()
    {

        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.nomClient) AS fact, SUBSTRING(v.nomClient, 1, 100000) AS prixfact')
            ->groupBy('prixfact');
        return $qb->getQuery()
            ->getResult();

    }
}
