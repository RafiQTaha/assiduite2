<?php

namespace App\Repository;

use App\Entity\AcDepartement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcDepartement|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcDepartement|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcDepartement[]    findAll()
 * @method AcDepartement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcDepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcDepartement::class);
    }

    // /**
    //  * @return AcDepartement[] Returns an array of AcDepartement objects
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
    public function findOneBySomeField($value): ?AcDepartement
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
