<?php

namespace App\Repository;

use App\Entity\Transport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transport[]    findAll()
 * @method Transport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transport::class);
    }

    // /**
    //  * @return Transport[] Returns an array of Transport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transport
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    function SearchType($type,$in,$out)
    {
        $query = $this->createQueryBuilder('t');

            if(!empty($type) && empty($in))
            {$query = $query
                ->andWhere('t.vers LIKE :nom')
                ->setParameter('nom','%'.$type.'%');

            }else if($type && $in)
            {$query = $query
                ->andWhere('t.vers LIKE :nom')
                ->setParameter('nom','%'.$type.'%')
                ->andWhere('t.date BETWEEN :in AND :out')
                ->setParameter('in',$in)
                ->setParameter('out',$out);
            }

             return $query->getQuery()->getResult();
    }



    public function OrderByNomQB()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.nom','DESC')
            ->getQuery() ->getResult();

    }
    public function OrderByPriceDQL()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select m from App\Entity\Transport m order by m.nom DESC');
        return $query->getResult();
    }
    public function OrderByPriceDQLASC()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select m from App\Entity\Transport m order by m.nom ASC');
        return $query->getResult();
    }
    public function countEtat()
    {

        $qb = $this->createQueryBuilder('k')
            ->select('COUNT(k.id) AS tran, SUBSTRING(k.id, 1, 10) AS e')
            ->groupBy('e');
        return $qb->getQuery()
            ->getResult();

    }

}
