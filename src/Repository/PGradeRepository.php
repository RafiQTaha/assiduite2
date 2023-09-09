<?php

namespace App\Repository;

use App\Entity\PGrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PGrade|null find($id, $lockMode = null, $lockVersion = null)
 * @method PGrade|null findOneBy(array $criteria, array $orderBy = null)
 * @method PGrade[]    findAll()
 * @method PGrade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PGradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PGrade::class);
    }

    // /**
    //  * @return PGrade[] Returns an array of PGrade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PGrade
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
