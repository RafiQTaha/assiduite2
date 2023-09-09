<?php

namespace App\Repository;

use App\Entity\NatureDemande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NatureDemande|null find($id, $lockMode = null, $lockVersion = null)
 * @method NatureDemande|null findOneBy(array $criteria, array $orderBy = null)
 * @method NatureDemande[]    findAll()
 * @method NatureDemande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NatureDemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NatureDemande::class);
    }

    // /**
    //  * @return NatureDemande[] Returns an array of NatureDemande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NatureDemande
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
