<?php

namespace App\Repository;

use App\Entity\PeStatut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PeStatut|null find($id, $lockMode = null, $lockVersion = null)
 * @method PeStatut|null findOneBy(array $criteria, array $orderBy = null)
 * @method PeStatut[]    findAll()
 * @method PeStatut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeStatutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PeStatut::class);
    }

    // /**
    //  * @return PeStatut[] Returns an array of PeStatut objects
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
    public function findOneBySomeField($value): ?PeStatut
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
