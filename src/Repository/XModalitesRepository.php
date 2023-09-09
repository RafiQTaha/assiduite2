<?php

namespace App\Repository;

use App\Entity\XModalites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method XModalites|null find($id, $lockMode = null, $lockVersion = null)
 * @method XModalites|null findOneBy(array $criteria, array $orderBy = null)
 * @method XModalites[]    findAll()
 * @method XModalites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XModalitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XModalites::class);
    }

    // /**
    //  * @return XModalites[] Returns an array of XModalites objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('x.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?XModalites
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
