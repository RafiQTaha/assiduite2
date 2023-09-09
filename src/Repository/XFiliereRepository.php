<?php

namespace App\Repository;

use App\Entity\XFiliere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method XFiliere|null find($id, $lockMode = null, $lockVersion = null)
 * @method XFiliere|null findOneBy(array $criteria, array $orderBy = null)
 * @method XFiliere[]    findAll()
 * @method XFiliere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XFiliereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, XFiliere::class);
    }

    // /**
    //  * @return XFiliere[] Returns an array of XFiliere objects
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
    public function findOneBySomeField($value): ?XFiliere
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
