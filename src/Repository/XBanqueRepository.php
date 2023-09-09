<?php

namespace App\Repository;

use App\Entity\XBanque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method XBanque|null find($id, $lockMode = null, $lockVersion = null)
 * @method XBanque|null findOneBy(array $criteria, array $orderBy = null)
 * @method XBanque[]    findAll()
 * @method XBanque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XBanqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XBanque::class);
    }

    // /**
    //  * @return XBanque[] Returns an array of XBanque objects
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
    public function findOneBySomeField($value): ?XBanque
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
