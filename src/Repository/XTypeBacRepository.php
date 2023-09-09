<?php

namespace App\Repository;

use App\Entity\XTypeBac;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method XTypeBac|null find($id, $lockMode = null, $lockVersion = null)
 * @method XTypeBac|null findOneBy(array $criteria, array $orderBy = null)
 * @method XTypeBac[]    findAll()
 * @method XTypeBac[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XTypeBacRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XTypeBac::class);
    }

    // /**
    //  * @return XTypeBac[] Returns an array of XTypeBac objects
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
    public function findOneBySomeField($value): ?XTypeBac
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
