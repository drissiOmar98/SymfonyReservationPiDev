<?php

namespace App\Repository;

use App\Entity\Maison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Maison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maison[]    findAll()
 * @method Maison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maison::class);
    }

    // /**
    //  * @return Maison[] Returns an array of Maison objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Maison
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }*/


    public function OrderByPriceDQL()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select m from App\Entity\Maison m order by m.prix DESC');
        return $query->getResult();
    }
    public function OrderByPrice()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select m from App\Entity\Maison m order by m.prix ASC');
        return $query->getResult();
    }
    public function getART()
    {

        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.prix) AS fact, SUBSTRING(v.prix, 1, 100000) AS prixfact')
            ->groupBy('prixfact');
        return $qb->getQuery()
            ->getResult();

    }





}
