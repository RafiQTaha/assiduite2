<?php

namespace App\Repository;

use App\Entity\AcPromotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcPromotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcPromotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcPromotion[]    findAll()
 * @method AcPromotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcPromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcPromotion::class);
    }

    // /**
    //  * @return AcPromotion[] Returns an array of AcPromotion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AcPromotion
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
