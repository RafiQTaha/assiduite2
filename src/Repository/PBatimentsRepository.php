<?php

namespace App\Repository;

use App\Entity\PBatiments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PBatiments|null find($id, $lockMode = null, $lockVersion = null)
 * @method PBatiments|null findOneBy(array $criteria, array $orderBy = null)
 * @method PBatiments[]    findAll()
 * @method PBatiments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PBatimentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PBatiments::class);
    }

    // /**
    //  * @return PBatiments[] Returns an array of PBatiments objects
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
    public function findOneBySomeField($value): ?PBatiments
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
