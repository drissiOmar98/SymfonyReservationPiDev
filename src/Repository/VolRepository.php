<?php

namespace App\Repository;

use App\Entity\Vol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vol|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vol|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vol[]    findAll()
 * @method Vol[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vol::class);
    }

    // /**
    //  * @return Vol[] Returns an array of Vol objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vol
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    function SearchVers($vers,$in,$out)
    {
        $query = $this->createQueryBuilder('v');

        if(!empty($vers) && empty($in))
        {$query = $query
            ->andWhere('v.vers LIKE :vers')
            ->setParameter('vers','%'.$vers.'%');

        }else if($vers && $in)
        {$query = $query
            ->andWhere('v.vers LIKE :vers')
            ->setParameter('vers','%'.$vers.'%')
            ->andWhere('v.dated BETWEEN :in AND :out')
            ->setParameter('in',$in)
            ->setParameter('out',$out);
        }
        return $query->getQuery()->getResult();
    }



    public function OrderByPrixQB()
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.prix','DESC')
            ->getQuery() ->getResult();

    }

    public function getART()
    {

        $qb = $this->createQueryBuilder('v')
            ->select('COUNT(v.nom) AS cvol, SUBSTRING(v.vers, 1, 100000) AS volt')
            ->groupBy('volt');
        return $qb->getQuery()
            ->getResult();

    }
}
