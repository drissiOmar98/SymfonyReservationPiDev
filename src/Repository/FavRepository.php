<?php

namespace App\Repository;

use App\Entity\Fav;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fav|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fav|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fav[]    findAll()
 * @method Fav[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fav::class);
    }

    // /**
    //  * @return Fav[] Returns an array of Fav objects
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
    public function findOneBySomeField($value): ?Fav
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
