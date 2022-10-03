<?php

namespace App\Repository;

use App\Entity\DetailReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailReservation[]    findAll()
 * @method DetailReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class detailReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailReservation::class);
    }

    // /**
    //  * @return DetailReservation[] Returns an array of DetailReservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailReservation
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
