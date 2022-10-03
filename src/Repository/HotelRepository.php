<?php

namespace App\Repository;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    // /**
    //  * @return Hotel[] Returns an array of Hotel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hotel
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    function SearchLieu($lieu,$in,$out)
    {
        $query = $this->createQueryBuilder('h');

        if(!empty($lieu) && empty($in))
        {$query = $query
            ->andWhere('h.lieu LIKE :li')
            ->setParameter('li','%'.$lieu.'%');

        }else if($lieu && $in)
        {$query = $query
            ->andWhere('h.lieu LIKE :li')
            ->setParameter('li','%'.$lieu.'%')
            ->andWhere('h.datevalidation BETWEEN :in AND :out')
            ->setParameter('in',$in)
            ->setParameter('out',$out);
        }

        return $query->getQuery()->getResult();
    }


    public function OrderByEtoileQB()
    {
        return $this->createQueryBuilder('h')
            ->orderBy('h.etoile','DESC')
            ->getQuery() ->getResult();

    }

    public function findStudentByNsc($nsc){
        return $this->createQueryBuilder('hotem')
            ->where('hotel.nsc LIKE :nsc')
            ->setParameter('nsc', '%'.$nsc.'%')
            ->getQuery()
            ->getResult();
    }

}
