<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Books|null find($id, $lockMode = null, $lockVersion = null)
 * @method Books|null findOneBy(array $criteria, array $orderBy = null)
 * @method Books[]    findAll()
 * @method Books[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    // /**
    //  * @return Books[] Returns an array of Books objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Books
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function OrderByPriceDQL()
    {
        $em = $this -> getEntityManager();
        $query = $em -> createQuery('select m from App\Entity\Books m order by m.id DESC');
        return $query->getResult();
    }
}
