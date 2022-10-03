<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    // /**
    //  * @return Offre[] Returns an array of Offre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offre
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /*
    public function OrderByTitreDQL()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select o from App\Entity\Offre o order by o.titre ASC');
        return $query->getResult();
    }

    public function OrderByTitreQB()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('o.titre','ASC')
            ->getQuery() ->getResult();
        ;
    }
    */


    function SearchNom($nom,$in,$out)
    {
        $query = $this->createQueryBuilder('o');

        if(!empty($nom) && empty($in))
        {$query = $query
            ->andWhere('o.nom LIKE :nom')
            ->setParameter('nom','%'.$nom.'%');

        }else if($nom && $in)
        {$query = $query
            ->andWhere('o.nom LIKE :nom')
            ->setParameter('nom','%'.$nom.'%')
            ->andWhere('o.dateValidite BETWEEN :in AND :out')
            ->setParameter('in',$in)
            ->setParameter('out',$out);
        }

        return $query->getQuery()->getResult();
    }



    public function OrderByTauxQB()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.tauxDeRemise','DESC')
            ->getQuery() ->getResult();

    }


    function SearchTitre($title)
    {
        return  $this->createQueryBuilder('o')
            ->where('o.nom LIKE ?1')
            ->setParameter('1','%'.$title.'%')
            ->getQuery()->getResult();
    }

    public function OrderByMailDQL()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select o from App\Entity\Offre o order by o.nom ASC');
        return $query->getResult();
    }

    public function OrderByMailQB()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.tauxDeRemise','DESC')
            ->getQuery() ->getResult();

    }

    public function OrderByMailQBback()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.nom','ASC')
            ->getQuery() ->getResult();

    }



















}
