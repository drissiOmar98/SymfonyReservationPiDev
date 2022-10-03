<?php

namespace App\Repository;

use App\Entity\Saisonoffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Saisonoffre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Saisonoffre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Saisonoffre[]    findAll()
 * @method Saisonoffre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreSaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Saisonoffre::class);
    }

    // /**
    //  * @return Saisonoffre[] Returns an array of Saisonoffre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Saisonoffre
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    function SearchSaison($title)
    {
        return  $this->createQueryBuilder('S')
            ->where('S.titresaison LIKE ?1')
            ->setParameter('1','%'.$title.'%')
            ->getQuery()->getResult();
    }


    public function OrderByTitleDQL()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select s from App\Entity\Saisonoffre s order by s.titresaison ASC');
        return $query->getResult();
    }

    public function OrderByTitleQB()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.titresaison','ASC')
            ->getQuery() ->getResult();
        ;
    }




    function listStudentByClass($id)
    {
        return $this -> createQueryBuilder('s') /* select from Student */
        ->join('s.idoffre','o')
            ->addSelect('o')
            ->where('o.idoffre=:id')
            ->setParameter('id',$id)
            ->getQuery() -> getResult();
    }






}
