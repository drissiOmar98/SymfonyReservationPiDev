<?php

namespace App\Repository;

use App\Entity\DetailT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailT|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailT|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailT[]    findAll()
 * @method DetailT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailT::class);
    }

    // /**
    //  * @return DetailT[] Returns an array of DetailT objects
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
    public function findOneBySomeField($value): ?DetailT
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
