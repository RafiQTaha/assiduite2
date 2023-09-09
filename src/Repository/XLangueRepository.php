<?php

namespace App\Repository;

use App\Entity\XLangue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method XLangue|null find($id, $lockMode = null, $lockVersion = null)
 * @method XLangue|null findOneBy(array $criteria, array $orderBy = null)
 * @method XLangue[]    findAll()
 * @method XLangue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XLangueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XLangue::class);
    }

    // /**
    //  * @return XLangue[] Returns an array of XLangue objects
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
    public function findOneBySomeField($value): ?XLangue
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
