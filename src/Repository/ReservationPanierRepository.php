<?php

namespace App\Repository;

use App\Entity\ReservationPanier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReservationPanier|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationPanier|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationPanier[]    findAll()
 * @method ReservationPanier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationPanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationPanier::class);
    }

    // /**
    //  * @return ReservationPanier[] Returns an array of ReservationPanier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservationPanier
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function OrderByPrix()
    {
        return $this->createQueryBuilder('reservation_panier')
            ->orderBy('reservation_panier.prix','DESC')
            ->getQuery() ->getResult();

    }
    public function findReservationByNsc($tt){
        return $this->createQueryBuilder('r')
            ->where('r.nsc LIKE :nsc')
            ->setParameter('nsc', '%'.$tt.'%')
            ->getQuery()
            ->getResult();
    }


}
