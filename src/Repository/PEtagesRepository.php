<?php

namespace App\Repository;

use App\Entity\PEtages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PEtages|null find($id, $lockMode = null, $lockVersion = null)
 * @method PEtages|null findOneBy(array $criteria, array $orderBy = null)
 * @method PEtages[]    findAll()
 * @method PEtages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PEtagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PEtages::class);
    }

    // /**
    //  * @return PEtages[] Returns an array of PEtages objects
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
    public function findOneBySomeField($value): ?PEtages
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
