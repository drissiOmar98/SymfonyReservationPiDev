<?php

namespace App\Repository;

use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }

    // /**
    //  * @return Events[] Returns an array of Events objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Events
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    function SearchLieu($lieu,$in,$out)
    {
        $query = $this->createQueryBuilder('e');

        if(!empty($lieu) && empty($in))
        {$query = $query
            ->andWhere('e.location LIKE :nom')
            ->setParameter('nom','%'.$lieu.'%');

        }else if($lieu && $in)
        {$query = $query
            ->andWhere('e.location LIKE :nom')
            ->setParameter('nom','%'.$lieu.'%')
            ->andWhere('e.date BETWEEN :in AND :out')
            ->setParameter('in',$in)
            ->setParameter('out',$out);
        }

        return $query->getQuery()->getResult();
    }

    public function OrderByPeriodQB()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.period','ASC')
            ->getQuery() ->getResult();

    }
    public function OrderByPriceDQL()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select e from App\Entity\Events e order by e.prix DESC');
        return $query->getResult();
    }
    public function OrderByPriceQB()
    {
        return $this->createQueryBuilder('e')//select
        ->orderBy('e.prix','ASC')
            ->getQuery() ->getResult();
        ;
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
